<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('drug_package_number');
            $table->integer('drug_unit_number')->nullable();
            $table->float('modified_drug_unit_sell_price')->nullable();
            $table->unsignedBigInteger('drug_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('drug_id')->references('id')->on('drugs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_invocie');
    }
}
