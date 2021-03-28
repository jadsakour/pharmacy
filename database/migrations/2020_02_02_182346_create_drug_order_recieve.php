<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugOrderRecieve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_order_recieve', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unit_number')->default(1);
            $table->float('package_net_price')->nullable();
            $table->float('unit_net_price')->nullable();
            $table->integer('recieved_packages_number');
            $table->integer('recieved_units_number')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
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
        Schema::dropIfExists('drug_order_recieve');
    }
}
