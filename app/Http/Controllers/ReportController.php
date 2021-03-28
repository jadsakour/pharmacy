<?php

namespace App\Http\Controllers;

use App\Models\AccountingOperation;
use App\Models\Company;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\WareHouse;
use DateTime;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Assign appropriate permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:report-show');
    }

    /**
     * Go to reports index page.
     */
    public function index()
    {
        $categories = DrugCategory::all();
        $warehouses = WareHouse::all();

        return view('reports.index')->with(['categories' => $categories, 'warehouses' => $warehouses]);
    }

    /**
     * Display the required report.
     */
    public function filter(Request $request)
    {
        // Get the report's type
        $report_type = $request->type;
        switch ($report_type) {
            case "1":
                return $this->companies_report();
                break;
            case "2":
                return $this->companies_sales_report($request);
                break;
            case "3":
                return $this->daily_sales_report();
                break;
            case "4":
                return $this->earnings_report($request);
                break;
            case "5":
                return $this->expenses_report($request);
                break;
            case "6":
                return $this->orders_report($request);
                break;
            case "7":
                return $this->expired_drug_report($request);
                break;
            case "8":
                return $this->warehouses_report($request);
                break;
            case "9":
                return $this->category_report($request);
                break;
            case "10":
                return $this->category_sales_report($request);
                break;
        }
    }

    /**
     * Report about the drugs for a certain category.
     *
     * @return \Illuminate\Http\Response
     */
    function category_report($request)
    {
        // Get the category
        $category = DrugCategory::find($request->category);
        // Get the related drugs for this category
        $drugs = $category->drugs()->get();
        // Return the appropriate view
        return view('reports.categoryReport')->with(['drugs' => $drugs]);
    }

    /**
     * Report about the sales for a certain category.
     *
     * @return \Illuminate\Http\Response
     */
    function category_sales_report($request)
    {
        // Get the category
        $category = DrugCategory::find($request->category);
        // Get the related drugs for this category
        $drugs = $category->drugs()->get();
        // Return the appropriate view
        return view('reports.categorySalesReport')->with(['drugs' => $drugs]);
    }

    /**
     * Report about the drugs of all companies.
     *
     * @return \Illuminate\Http\Response
     */
    function companies_report()
    {
        // Get the companies
        $companies = Company::all();
        // Return the appropriate view
        return view('reports.companiesReport')->with(['companies' => $companies]);
    }

    /**
     * Report about the sales of all companies.
     * The result is returned as an array, each element of this array has the following structure:
     * [company's name, the sum of all sell prices after discount]
     *
     * @return \Illuminate\Http\Response
     */
    function companies_sales_report($request)
    {
        // Contains the final result
        $result = array();
        // Get the companies
        $companies = Company::all();
        foreach ($companies as $company) {
            $info = array();
            $sell_prices = 0;
            foreach ($company->drugs as $drug) {
                $sell_prices += $drug->invoices
                    ->whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->input('start-date'))), date('Y-m-d 23:59:59', strtotime($request->input('end-date')))])
                    ->sum('sell_price_after_discount');
            }
            // No need to return the company sales if there are not any sales
            if ($sell_prices != 0) {
                array_push($info, $company->name);
                array_push($info, $sell_prices);
                array_push($result, $info);
            }
        }
        // Return the appropriate view
        return view('reports.companiesSalesReport')->with(['companies' => $result]);
    }

    /**
     * Report about the daily sales.
     * The result is returned as an array, each element of this array has the following structure:
     * [invoice's id, sell price after discount, remaining amount]
     *
     * @return \Illuminate\Http\Response
     */
    function daily_sales_report()
    {
        // Contains the final result
        $result = array();
        // Get all invoices for the current day
        $invoices = Invoice::whereBetween('date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->get();
        // Return the appropriate view
        return view('reports.DailySalesReport')->with(['invoices' => $invoices]);
    }

    /**
     * The result is returned as an array which has the following structure:
     * []
     *
     * @return \Illuminate\Http\Response
     */
    function earnings_report(Request $request)
    {
        // Contains the final result
        $result = array();
        // Get all invoices for the current day
        $invoices = Invoice::whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->input('start-date'))), date('Y-m-d 23:59:59', strtotime($request->input('end-date')))])->get();
        $sells = 0;
        $un_paid_sells = 0;
        // Loop over the invoices
        foreach ($invoices as $invoice) {
            $sells += $invoice->sell_price_after_discount;
            $un_paid_sells += $invoice->sell_price_after_discount - $invoice->operations->sum('amount');
        }
        // Get all orders for the current day
        $orders = Order::whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->input('start-date'))), date('Y-m-d 23:59:59', strtotime($request->input('end-date')))])->get();
        $sells_orders = 0;
        $un_paid_orders = 0;
        // Loop over the invoices
        foreach ($orders as $order) {
            $sells_orders += $order->net_price;
            $un_paid_orders += $order->net_price - $order->operations->sum('amount');
        }
        // Get all the accounting operations (which now made by an invoice or an order)
        $expenses = 0;
        $operations = AccountingOperation::where('operationable_id', null)->whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->input('start-date'))), date('Y-m-d 23:59:59', strtotime($request->input('end-date')))])->get();
        foreach ($operations as $operation) {
            $expenses += $operation->amount;
        }
        array_push($result, $sells, $un_paid_sells, $sells_orders, $un_paid_orders, $expenses);
        // Return the appropriate view
        return view('reports.EarningsAndBudgetReport')->with(['prices' => $result]);
    }

    /**
     * The result of expenses spended in a period.
     *
     * @return \Illuminate\Http\Response
     */
    function expenses_report(Request $request)
    {
        // Get all the accounting operations (which now made by an invoice or an order)
        $operations = AccountingOperation::where('operationable_id', null)
            ->whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->input('start-date'))), date('Y-m-d 23:59:59', strtotime($request->input('end-date')))])
            ->get();
        // Return the appropriate view
        return view('reports.ExpenseReport')->with(['operations' => $operations]);
    }

    /**
     * Report about the daily sales.
     * The result is returned as an array, each element of this array has the following structure:
     * [invoice's id, sell price after discount, remaining amount]
     *
     * @return \Illuminate\Http\Response
     */
    function orders_report(Request $request)
    {
        // Get all orders for the current day
        $orders = Order::whereBetween('date', [date('Y-m-d 00:00:00', strtotime($request->input('start-date'))), date('Y-m-d 23:59:59', strtotime($request->input('end-date')))])->get();
        // Return the appropriate view
        return view('reports.PurchasesReport')->with(['orders' => $orders]);
    }

    /**
     * Report expired drugs.
     * The result is an array of the expired drug repo.
     *
     * @return \Illuminate\Http\Response
     */
    function expired_drug_report(Request $request)
    {
        // Remaining months
        $months = $request->months;
        // Final result
        $result = array();
        // Get all drugs
        $drugs = Drug::all();
        // Add the expired drugs only
        foreach ($drugs as $drug) {
            foreach ($drug->repo()->whereDate('exp_date', '<', date('Y-m-d', strtotime("+$months months", strtotime(date('Y-m-d')))))->get() as $drug_repo) {
                array_push($result, $drug_repo);
            }
        }
        // Return the appropriate view
        return view('reports.QuantitiesOfExpiredDrugs')->with(['drugs' => $result, 'months' => $months]);
    }

    /**
     * Report of warehouses.
     *
     * @return \Illuminate\Http\Response
     */
    function warehouses_report($request)
    {
        // Get all orders for the current day
        if ($request->warehouse != "") {
            $warehouses = WareHouse::where('id', $request->warehouse)->get();
        } else {
            $warehouses = WareHouse::all();
        }
        // Return the appropriate view
        return view('reports.WarehouseOrdersReport')->with(['warehouses' => $warehouses, 'start_date' => $request->input('start-date'), 'end_date' => $request->input('end-date')]);
    }
}
