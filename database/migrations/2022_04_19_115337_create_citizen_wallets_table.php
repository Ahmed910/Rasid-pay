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
            $table->integer("wallet_number")->unique();
            $table->foreignUuid("citizen_id")->constrained("users")->onDelete("cascade");
            $table->string("total_balance");
            $table->string("main_balance");
            $table->string("gift_balance");
            $table->string("dept_balance");
            $table->string("transferred_balance");
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
