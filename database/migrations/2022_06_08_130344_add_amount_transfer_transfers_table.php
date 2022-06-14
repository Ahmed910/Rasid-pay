<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountTransferTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_wallets', function (Blueprint $table) {
            $table->decimal('hold_back_balance', 12, 2)->default(0);
            $table->decimal('hold_main_balance', 12, 2)->default(0);
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->decimal('cashback_amount', 12, 2)->default(0);
            $table->decimal('main_amount', 12, 2)->default(0);
        });
        Schema::table('bank_transfers', function (Blueprint $table) {
            $table->decimal('converting_amount', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('citizen_wallets', function (Blueprint $table) {
            $table->dropColumn('hold_back_balance','hold_main_balance');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn('cashback_amount','main_amount');
        });
        Schema::table('bank_transfers', function (Blueprint $table) {
            $table->dropColumn('converting_amount');
        });
    }
}
