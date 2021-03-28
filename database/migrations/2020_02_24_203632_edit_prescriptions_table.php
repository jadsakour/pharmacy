<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->float('discount_amount')->nullable()->after('id');
            $table->unsignedBigInteger('insurance_company_id')->nullable()->after('discount_amount');
            $table->foreign('insurance_company_id')->references('id')->on('insurance_companies')->onUpdate('cascade')->onDelete('set null');
            $table->float('sell_price')->nullable()->after('insurance_company_id');
            $table->float('sell_price_after_discount')->nullable()->after('sell_price');
            $table->float('net_price')->nullable()->after('sell_price_after_discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn('discount_amount');
            $table->dropColumn('insurance_company_id');
            $table->dropColumn('sell_price');
            $table->dropColumn('net_price');
            $table->dropColumn('sell_price_after_discount');
        });
    }
}
