<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDrugsRepoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drugs_repo', function (Blueprint $table) {
            $table->integer('unit_number')->default(1)->after('id');
            $table->float('package_net_price')->nullable()->after('packages_number');
            $table->float('package_sell_price')->nullable()->after('package_net_price');
            $table->float('unit_net_price')->nullable()->after('package_sell_price');
            $table->float('unit_sell_price')->nullable()->after('unit_net_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drugs_repo', function (Blueprint $table) {
            $table->dropColumn('unit_number');
            $table->dropColumn('package_net_price');
            $table->dropColumn('package_sell_price');
            $table->dropColumn('unit_net_price');
            $table->dropColumn('unit_sell_price');
        });
    }
}
