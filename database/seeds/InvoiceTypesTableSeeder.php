<?php

use Illuminate\Database\Seeder;
use App\Models\InvoiceType;

class InvoiceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the appropriate types
        $sell_invoice = new InvoiceType();
        $sell_invoice->name = "sell";

        $buy_order_invoice = new InvoiceType();
        $buy_order_invoice->name = "buy_order";

        $buy_receive_invoice = new InvoiceType();
        $buy_receive_invoice->name = "buy_receive";

        // Save it to the database
        $sell_invoice->save();
        $buy_order_invoice->save();
        $buy_receive_invoice->save();
    }
}
