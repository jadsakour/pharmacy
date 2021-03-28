<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDrugInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drug_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('drug_repo_id')->nullable()->after('drug_id');
            $table->foreign('drug_repo_id')->references('id')->on('drugs_repo')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_invoice', function (Blueprint $table) {
            $table->dropColumn('drug_repo_id');
        });
    }
}
