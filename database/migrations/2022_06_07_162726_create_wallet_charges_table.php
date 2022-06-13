<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_charges', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("citizen_id")->nullable()->constrained("users")->OnDelete('set null');
            $table->string('amount');
            $table->string('wallet_before');
            $table->string('wallet_after');
            $table->enum('charge_type', ['nfc', 'manual', 'sadad', 'scan']);
            $table->timestamp('last_updated_at');
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
        Schema::dropIfExists('wallet_charges');
    }
}
