<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastUpdatedAtToCitizenWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citizen_wallets', function (Blueprint $table) {
            $table->timestamp('last_updated_at')->useCurrent()->useCurrentOnUpdate()->after('wallet_qr');
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
            $table->dropColumn('last_updated_at');
        });
    }
}
