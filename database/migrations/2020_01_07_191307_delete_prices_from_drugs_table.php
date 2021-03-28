<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePricesFromDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drugs', function (Blueprint $table) {
          $table->dropColumn('net_price');
          $table->dropColumn('sell_price');
          $table->dropColumn('unit_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->integer('unit_number')->default(1)->after('volume_unit');
            $table->integer('net_price')->after('unit_number');
            $table->integer('sell_price')->after('net_price');
        });
    }
}
