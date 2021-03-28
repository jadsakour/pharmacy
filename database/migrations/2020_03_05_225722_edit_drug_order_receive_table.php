<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDrugOrderReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drug_order_recieve', function (Blueprint $table) {
            $table->unsignedBigInteger('drug_id')->nullable()->after('recieved_units_number');
            $table->foreign('drug_id')->references('id')->on('drugs')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_order_recieve', function (Blueprint $table) {
            $table->dropColumn('drug_id');
        });
    }
}
