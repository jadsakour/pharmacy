<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDrugOrderSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drug_order_send', function (Blueprint $table) {
            $table->dropColumn('drug_package_number');
            $table->dropColumn('drug_unit_number');
            $table->integer('ordered_packages_number')->after('id');
            $table->integer('ordered_units_number')->after('ordered_packages_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_order_send', function (Blueprint $table) {
            $table->dropColumn('ordered_packages_number');
            $table->dropColumn('ordered_units_number');
            $table->integer('drug_package_number')->after('id');
            $table->integer('drug_unit_number')->after('drug_package_number')->nullable();
        });
    }
}
