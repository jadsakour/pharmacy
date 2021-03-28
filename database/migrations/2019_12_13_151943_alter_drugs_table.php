<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn('shape');
            $table->integer('unit_number')->default(1)->after('volume_unit');
            $table->unsignedBigInteger('shape_id')->nullable()->after('global_barcode');
            $table->foreign('shape_id')->references('id')->on('drug_shapes')->onUpdate('cascade')->onDelete('set null');
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
            $table->string('shape');
            $table->dropColumn('shape_id');
        });
    }
}
