<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string("total_amount")->default(0);
            $table->string("main_balance")->default(0);
            $table->string("gift_balance")->default(0);
            $table->string("discount_percent")->default(0);
            $table->foreignUuid("from_user_id")->constrained("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('total_amount');
            $table->dropColumn('main_balance');
            $table->dropColumn('gift_balance');
            $table->dropColumn('discount_percent');
            $table->dropForeign('from_user_id');
            $table->dropColumn('from_user_id');
        });
    }
}
