<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorDataToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignUuid('vendor_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->text('vendor_data')->nullable();
            $table->string('vendor_discount')->nullable();
        });
    }


    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropColumn('vendor_id', 'vendor_data', 'vendor_discount');
        });
    }
}
