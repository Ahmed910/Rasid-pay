<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefusedReasonColumnToTransferedBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfered_balances', function (Blueprint $table) {
            $table->text('refused_reason')->nullable()->after('transfer_fees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfered_balances', function (Blueprint $table) {
            $table->dropColumn('refused_reason');
        });
    }
}
