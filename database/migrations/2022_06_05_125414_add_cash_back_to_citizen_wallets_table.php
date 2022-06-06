<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashBackToCitizenWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_wallets', function (Blueprint $table) {
            $table->string('cash_back')->default(0)->after('main_balance');
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
            $table->dropColumn('cash_back');
        });
    }
}
