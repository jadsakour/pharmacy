<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->float('net_price')->nullable();
            $table->float('sell_price')->nullable();
            $table->boolean('is_paid');
            $table->string('notes')->nullable();
            $table->float('discount_percentage')->nullable();
            $table->float('discount_amount')->nullable();
            $table->string('discount_reason')->nullable();
            $table->unsignedBigInteger('insurance_company_id')->nullable();
            $table->foreign('insurance_company_id')->references('id')->on('insurance_companies')->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('invoice_type_id')->nullable();
            $table->foreign('invoice_type_id')->references('id')->on('invoice_types')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('invoices');
    }
}
