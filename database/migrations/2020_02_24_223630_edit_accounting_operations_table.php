<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAccountingOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_operations', function (Blueprint $table) {
            $table->dropForeign('accounting_operations_invoice_id_foreign');
            $table->dropColumn('invoice_id');
            $table->unsignedBigInteger('operationable_id')->nullable()->after('accounting_type_id');
            $table->string('operationable_type')->nullable()->after('operationable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_operations', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->nullable()->after('accounting_type_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn('operationable_id');
            $table->dropColumn('operationable_type');
        });
    }
}
