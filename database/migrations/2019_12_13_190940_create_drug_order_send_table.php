<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugOrderSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_order_send', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('drug_package_number');
            $table->integer('drug_unit_number')->nullable();
            $table->unsignedBigInteger('drug_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('drug_id')->references('id')->on('drugs')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('drug_order');
    }
}
