<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugsRepoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs_repo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('pro_date')->nullable();
            $table->date('exp_date');
            $table->integer('units_number');
            $table->integer('packages_number');
            $table->boolean('isDisposed')->default(false);
            $table->unsignedBigInteger('drug_id');
            $table->foreign('drug_id')->references('id')->on('drugs')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('drugs_repo');
    }
}
