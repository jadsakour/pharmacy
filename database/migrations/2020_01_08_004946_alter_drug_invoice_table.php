<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDrugInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drug_invoice', function (Blueprint $table) {
            $table->float('modified_drug_package_sell_price')->nullable()->after('drug_unit_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_invoice', function (Blueprint $table) {
            $table->droupColumn('modified_drug_package_sell_price');
        });
    }
}
