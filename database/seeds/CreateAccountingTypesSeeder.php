<?php

use Illuminate\Database\Seeder;
use App\Models\AccountingType;

class CreateAccountingTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the initial invoices types
        $invoice_sell_type = new AccountingType();
        $invoice_sell_type->name = "فاتورة مبيعات";

        $invoice_order_type = new AccountingType();
        $invoice_order_type->name = "فاتورة مشتريات أدوية";

        $invoice_customer_type = new AccountingType();
        $invoice_customer_type->name = "فاتورة زبون";

        // Save the, to the database
        $invoice_sell_type->save();
        $invoice_order_type->save();
        $invoice_customer_type->save();
    }
}
