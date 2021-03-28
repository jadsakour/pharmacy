<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDrugPrescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drug_prescription', function (Blueprint $table) {
            $table->integer('packages_number')->default(0)->nullable()->after('prescription_id');
            $table->integer('units_number')->default(0)->nullable()->after('packages_number');
            $table->float('package_sell_price')->default(0)->nullable()->after('units_number');
            $table->float('unit_sell_price')->default(0)->nullable()->after('package_sell_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_prescription', function (Blueprint $table) {
            $table->dropColumn('packages_number');
            $table->dropColumn('units_number');
            $table->dropColumn('package_sell_price');
            $table->dropColumn('unit_sell_price');
        });
    }
}
