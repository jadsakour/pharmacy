<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugPrescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_prescription', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('drug_id')->nullable();
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->foreign('drug_id')->references('id')->on('drugs')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('drug_prescription');
    }
}
