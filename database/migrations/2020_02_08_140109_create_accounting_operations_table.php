<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->float('amount');
            $table->unsignedBigInteger('accounting_type_id');
            $table->foreign('accounting_type_id')->references('id')->on('accounting_types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('accounting_operations');
    }
}
