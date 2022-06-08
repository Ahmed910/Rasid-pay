<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizenWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizen_wallets', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->bigInteger("wallet_number")->unique();
            $table->foreignUuid("citizen_id")->constrained("users")->onDelete("cascade");
            $table->string("total_balance")->default(0);
            $table->string("main_balance")->default(0);
            $table->string("gift_balance")->default(0);
            $table->string("dept_balance")->default(0);
            $table->string("transferred_balance")->default(0);
            $table->string("wallet_qr")->nullable();
            $table->string('cash_back')->default(0);
            $table->timestamp('last_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citizen_wallets');
    }
}
