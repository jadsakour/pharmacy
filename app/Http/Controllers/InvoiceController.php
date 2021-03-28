<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Drug;
use App\Models\InvoiceType;
use App\Models\InsuranceCompany;
use App\Models\Order;
use App\Models\WareHouse;
use App\Models\Company;
use App\Models\DrugOrderSend;
use App\Models\DrugOrderReceive;
use App\Models\Balance;
use App\Models\AccountingType;
use App\Models\AccountingOperation;
use App\Http\Controllers\DrugController;
use App\Models\DrugCategory;
use App\Models\DrugShape;

class InvoiceController extends Controller
{
    /**
     * Assign appropriate permissions.
     *
     * The required permissions are:
     * 'invoice-pay', 'invoice-sell-list', 'invoice-sell-show', 'invoice-sell-create', 'invoice-sell-insurance-create',
     * 'invoice-order-create', invoice-order-list', 'invoice-order-show', 'invoice-order-receive'
     */
    public function __construct()
    {
        $this->middleware(
            'permission:invoice-sell-list|invoice-sell-show|invoice-order-list|invoice-order-show',
            ['only' => ['get_sell_invoices', 'show_sell_invoice', 'get_all_orders', 'show_order', 'get_drug_by_id_for_prescription', 'calculate_prices']]
        );
        $this->middleware(
            'permission:invoice-sell-create|invoice-sell-insurance-create|drug-repo-update-sell',
            ['only' => ['create_sell_invoice', 'create_sell_invoice_insurance', 'store_invoice', 'handle_sell_invoice']]
        );
        $this->middleware('permission:invoice-pay', ['only' => ['pay_for_invoice', 'do_pay_for_invoice']]);

        $this->middleware(
            'permission:invoice-order-create',
            ['only' => ['create_buy_order_invoice', 'store_invoice', 'store_invoice', 'handle_buy_order_invoice']]
        );
        $this->middleware('permission:invoice-order-receive', ['only' => ['create_order_receive_invoice', 'store_invoice', 'handle_buy_receive_invoice']]);
    }

    /**
     * Return the appropriate view to create a sell invoice.
     *
     * @return \Illuminate\Http\Response
     */
    function create_sell_invoice()
    {
        $shapes = DrugShape::all();
        $categories = DrugCategory::all();
        $companies = Company::all();

        // Return the appropriate view
        return view('invoice.create')->with([
            'shapes' => $shapes,
            'categories' => $categories,
            'companies' => $companies
        ]);
    }

    /**
     * Return the appropriate view to create a sell invoice.
     *
     * @return \Illuminate\Http\Response
     */
    function create_sell_invoice_insurance()
    {
        $insurance_companies = InsuranceCompany::all();
        $shapes = DrugShape::all();
        $categories = DrugCategory::all();
        $companies = Company::all();

        // Return the appropriate view
        return view('invoice.create_with_insurance')->with([
            'shapes' => $shapes,
            'categories' => $categories,
            'companies' => $companies,
            'insurance_companies' => $insurance_companies
        ]);
    }

    /**
     * Display all sell invoices.
     *
     * @return \Illuminate\Http\Response
     */
    function get_sell_invoices()
    {
        $invoices = Invoice::orderBy('date', 'desc')->get();
        return view('invoice.index')->with(['invoices' => $invoices]);
    }

    /**
     * Display detailed sell invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_sell_invoice($id)
    {
        $invoice = Invoice::find($id);
        return view('invoice.show')->with('invoice', $invoice);
    }

    /**
     * Return the appropriate view to pay for an invoice.
     *
     * @return \Illuminate\Http\Response
     */
    function pay_for_invoice($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        return view('invoice.payment')->with(['invoice' => $invoice]);
    }

    /**
     * Pay for an invoice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $invoice_id
     *
     * @return \Illuminate\Http\Response
     */
    function do_pay_for_invoice(Request $request, $invoice_id)
    {
        // Get the invoice
        $invoice = Invoice::find($invoice_id);

        // Get the amount to be paid
        $amount = $request->input('amount');

        // Calculate the paid amount for this invoice
        $paid = $invoice->operations->sum('amount');

        // Create the appropriate accounting operation
        $accounting_type = AccountingType::where('name', 'فاتورة مبيعات')->first();
        $accounting_operation = new AccountingOperation;
        $accounting_operation->date = $request->input('date') == null ? date('Y-m-d H:i:s') : $request->input('date');
        $accounting_operation->amount = $amount;
        $accounting_operation->type()->associate($accounting_type);
        $accounting_operation->operationable()->associate($invoice);
        $accounting_operation->save();

        // Add it to the balance table
        $balance = Balance::first();
        $balance->balance += $amount;
        $balance->save();

        // Check if the invoice is paid
        if ($paid + $amount >= $invoice->sell_price_after_discount) {
            $invoice->is_paid = true;
            $invoice->save();
        }

        return redirect()->route('invoice.index');
    }

    /**
     * Display all orders.
     *
     * @return \Illuminate\Http\Response
     */
    function get_all_orders()
    {
        $orders = Order::all();
        return view('order.index')->with(['orders' => $orders]);
    }

    /**
     * Return the appropriate view to create a buy order invoice.
     *
     * @return \Illuminate\Http\Response
     */
    function create_buy_order_invoice()
    {
        $shapes = DrugShape::all();
        $categories = DrugCategory::all();
        $companies = Company::all();
        // Get all companies
        $companies = Company::all();
        // Get all warehouses
        $warehouses = WareHouse::all();
        // Return the appropriate view
        return view('order.create')->with([
            'companies' => $companies,
            'warehouses' => $warehouses,
            'shapes' => $shapes,
            'categories' => $categories,
            'companies' => $companies
        ]);
    }

    /**
     * Return the appropriate view to receive an order.
     *
     * @return \Illuminate\Http\Response
     */
    function create_order_receive_invoice($order_id)
    {
        $order = Order::find($order_id);
        return view('order.receive')->with(['order' => $order]);
    }

    /**
     * Show a detailed view of an order.
     *
     * @return \Illuminate\Http\Response
     */
    function show_order($order_id)
    {
        $order = Order::find($order_id);
        return view('order.show')->with(['order' => $order]);
    }

    /**
     * This is the route method that is responsible for handling every types of invoices.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store_invoice(Request $request)
    {
        if ($request->ajax()) {
            // Initiate the drugs repository controller
            $repo_controller = new DrugController;
            // Get the invoice type
            $invoice_type = InvoiceType::find($request->input('invoice_type_id'));

            switch ($invoice_type->name) {
                case 'sell':
                    // Handle the sell invoice
                    $prices = $this->handle_sell_invoice($invoice_type, $repo_controller, $request);
                    return $prices;
                    break;

                case 'buy_order':
                    // Handle the buy order send invoice
                    $this->handle_buy_order_invoice($request);
                    break;

                case 'buy_receive':
                    // Handle buy receive order invoice
                    $this->handle_buy_receive_invoice($repo_controller, $request);
                    break;

                case 'dispose':

                default:
                    // code...
                    break;
            }
        }
    }

    /**
     * An internal method responsible for handling the sell invoice.
     */
    function handle_sell_invoice($invoice_type, $repo_controller, $request)
    {
        // Create the new sell invoice instance
        $invoice = new Invoice;
        // Associate the invoice type
        $invoice->invoice_type()->associate($invoice_type);

        // Assign the shared invoce values from the request
        $invoice->date = $request->input('date') == null ? date('Y-m-d H:i:s') : $request->input('date');
        $invoice->notes = $request->input('notes');
        // Set the discount reason if any
        $invoice->discount_reason = 'لا يوجد سبب';

        // Get the drugs ids and information
        $drugs_ids = $request->input('drugs.ids.*');
        $drugs_packages_number = $request->input('drugs.packages_number.*');
        $drugs_units_number = $request->input('drugs.units_number.*');
        $modified_drugs_package_sell_price = $request->input('drugs.modified_drugs_package_sell_price.*');
        $modified_drugs_unit_sell_price = $request->input('drugs.modified_drugs_unit_sell_price.*');

        // Drugs info
        // Each element will have the following structure
        // [Drug ID, Packages number, Units number, New package sell price, New unit sell price]
        $drugs_info = array();

        for ($i = 0; $i < count($drugs_ids); $i++) {
            // Create each list entry of the drugs list
            $drug_info = array($drugs_ids[$i], $drugs_packages_number[$i], $drugs_units_number[$i], $modified_drugs_package_sell_price[$i], $modified_drugs_unit_sell_price[$i]);
            array_push($drugs_info, $drug_info);
        }
        // Calculate the prices and update the drugs repository
        $invoice->is_paid = false;
        $invoice->sell_price_after_discount = 0;
        $invoice->save();

        // We need to save the new sell invoice in order to get its ID
        $prices = $repo_controller->update_drug_repo_from_sell_invoice($invoice->id, $drugs_info);
        $invoice->net_price = $prices[0];
        $invoice->sell_price = $prices[1];

        $invoice->save();
        // Handle discount
        if ($request->input('discount_amount') != null) {
            $invoice->discount_amount = $request->input('discount_amount');
            $invoice->sell_price_after_discount = $invoice->sell_price - $invoice->discount_amount;
            $invoice->discount_reason = $request->input('discount_reason');
            $invoice->discount_percentage = 0;
            $invoice->insurance_company_id = null;
        } else {
            if ($request->input('insurance_company_id') != null) {
                $insurance_company = InsuranceCompany::find($request->input('insurance_company_id'));
                $invoice->discount_percentage = $insurance_company->discount;
                $invoice->discount_amount = $invoice->sell_price * ($invoice->discount_percentage / 100);
                $invoice->sell_price_after_discount = $invoice->sell_price - $invoice->discount_amount;
                $invoice->discount_reason = $request->input('discount_reason');
                $invoice->insurance_company()->associate($insurance_company);
            } else {
                $invoice->discount_percentage = 0;
                $invoice->discount_amount = 0;
                $invoice->insurance_company_id = null;
            }
        }

        $amount = $request->input('amount');
        // Get the total payments for this invoice
        $paid_amount = $invoice->operations()->sum('amount');
        if ($paid_amount + $amount >= $invoice->sell_price_after_discount) {
            $invoice->is_paid = true;
        }
        // Save
        $invoice->save();

        // Create the appropriate accounting operation
        $accounting_type = AccountingType::where('name', 'فاتورة مبيعات')->first();
        $accounting_operation = new AccountingOperation;
        $accounting_operation->date = $request->input('date') == null ? date('Y-m-d H:i:s') : $request->input('date');
        $accounting_operation->amount = $amount;
        $accounting_operation->type()->associate($accounting_type);
        $accounting_operation->operationable()->associate($invoice);
        $accounting_operation->save();

        // Add it to the balance table
        $balance = Balance::first();
        $balance->balance += $amount;
        $balance->save();

        exit;
    }

    /**
     * An internal method responsible for handling the but order invoice.
     */
    function handle_buy_order_invoice($request)
    {
        // Create a new Order instance.
        $order = new Order;
        $order->date = date('Y-m-d');
        $order->net_price = 0;

        // Check if the supplier is a company or a warehouse, and bind it to the order
        $supplier = WareHouse::find($request->input('supplier_id'));
        if (!$supplier) {
            $supplier = Company::find($request->input('supplier_id'));
            $order->orderable()->associate($supplier);
        } else {
            $order->orderable()->associate($supplier);
        }
        // To generate the order ID
        $order->save();
        // Get the required information from the request
        $drugs_ids = $request->input('drugs.ids.*');
        $drugs_packages_number = $request->input('drugs.packages_number.*');
        $drugs_units_number = $request->input('drugs.units_number.*');

        // Loop over the drugs, and create an appropriate entry in the drug_order_send table
        for ($i = 0; $i < count($drugs_ids); $i++) {
            $drug_order_send = new DrugOrderSend;
            $drug_order_send->drug()->associate(Drug::find($drugs_ids[$i]));
            $drug_order_send->order()->associate($order);
            $drug_order_send->ordered_packages_number = $drugs_packages_number[$i];
            $drug_order_send->ordered_units_number = $drugs_units_number[$i];
            $drug_order_send->save();
        }
        exit;
    }

    /**
     * An internal method responsible for handling the buy receive invoice.
     */
    function handle_buy_receive_invoice($repo_controller, $request)
    {
        // Get the drugs ids and information
        $order_id = $request->input('order_id');
        $order = Order::find($order_id);
        $drugs_ids = $request->input('drugs.ids.*');
        $drugs_unit_number = $request->input('drugs.unit_number.*');
        $drugs_packages_number = $request->input('drugs.packages_number.*');
        $drugs_units_number = $request->input('drugs.units_number.*');
        $drugs_package_net_price = $request->input('drugs.package_net_price.*');
        $drugs_unit_net_price = $request->input('drugs.unit_net_price.*');
        $drugs_package_sell_price = $request->input('drugs.package_sell_price.*');
        $drugs_unit_sell_price = $request->input('drugs.unit_sell_price.*');
        $drugs_expiration_dates = $request->input('drugs.expiration_date.*');
        $drugs_production_dates = $request->input('drugs.production_date.*');

        // Drugs info
        // Each element will have the following structure
        // [Drug ID, Unit number, Packages number, Units number, Expiration date, Production date, Package Sell price, Package Net price, Unit Sell price, Unit Net price]
        $drugs_info = array();

        for ($i = 0; $i < count($drugs_ids); $i++) {
            // Create each list entry of the drugs list
            $drug_info = array(
                $drugs_ids[$i], $drugs_unit_number[$i], $drugs_packages_number[$i], $drugs_units_number[$i],
                $drugs_expiration_dates[$i], $drugs_production_dates[$i],
                $drugs_package_sell_price[$i], $drugs_package_net_price[$i],
                $drugs_unit_sell_price[$i], $drugs_unit_net_price[$i]
            );
            array_push($drugs_info, $drug_info);
            $drug_order_receive = new DrugOrderReceive;
            $drug_order_receive->order()->associate($order);
            $drug_order_receive->drug()->associate(Drug::find($drugs_ids[$i]));
            $drug_order_receive->unit_number = $drugs_unit_number[$i];
            $drug_order_receive->package_net_price = $drugs_package_net_price[$i];
            $drug_order_receive->unit_net_price = $drugs_unit_net_price[$i];
            $drug_order_receive->recieved_packages_number = $drugs_packages_number[$i];
            $drug_order_receive->recieved_units_number = $drugs_units_number[$i];
            $drug_order_receive->save();
        }

        // Update the repo
        $repo_controller->update_drugs_repo_from_incoming_invoice($order_id, $drugs_info);
        $order->is_delivered = true;
        $order->net_price = $request->input('net_price');
        $order->save();

        // Add the appropriate accounting operation
        $accounting_type = AccountingType::where('name', 'فاتورة مشتريات أدوية')->first();
        $accounting_operation = new AccountingOperation;
        $accounting_operation->date = $request->input('date') == null ? date('Y-m-d') : $request->input('date');
        $accounting_operation->amount = $request->input('amount') == null ? $order->net_price : $request->input('amount');
        $accounting_operation->type()->associate($accounting_type);
        $accounting_operation->operationable()->associate($order);
        $accounting_operation->save();

        // Add it to the balance table
        $balance = Balance::all()[0];
        $balance->balance -= $order->net_price;
        $balance->save();

        exit;
    }

    /**
     * Delete an invoice with all its resources.
     *
     * @return \Illuminate\Http\Response
     */
    function delete($id)
    {
        $invoice = Invoice::find($id);
        $paid_amount = $invoice->operations->sum('amount');
        foreach ($invoice->drug_repo as $drug_repo) {
            $drug_repo->packages_number += $drug_repo->pivot->drug_package_number;
            $drug_repo->units_number += $drug_repo->pivot->drug_unit_number;
        }
        $invoice->push();

        // Delete invoice payments
        foreach ($invoice->operations as $operation) {
            $operation->delete();
        }

        $invoice->delete();

        // Remove it to the balance table
        $balance = Balance::all()[0];
        $balance->balance -= $paid_amount;
        $balance->save();

        return redirect()->route('invoice.index');
    }
}
