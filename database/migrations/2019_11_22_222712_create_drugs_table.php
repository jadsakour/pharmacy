<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_english');
            $table->string('name_arabic')->nullable();
            $table->string('chemical_composition');
            $table->string('shape');
            $table->string('volume_unit')->nullable();
            $table->integer('net_price');
            $table->integer('sell_price');
            $table->integer('lic_palte')->nullable();
            $table->string('local_barcode')->nullable();
            $table->string('global_barcode')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('category_id')->references('id')->on('drug_categories')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('drugs');
    }
}
