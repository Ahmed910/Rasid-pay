<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferedBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfered_balances', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('citizen_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignUuid('transfer_to_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('from_identity_number');
            $table->string('to_identity_number');
            $table->string('account_number')->nullable();
            $table->string('transfer_to_account_number')->nullable();
            $table->string('wallet_number')->nullable();
            $table->string('transfer_to_wallet')->nullable();
            $table->foreignUuid('bank_id')->nullable()->constrained('banks')->onDelete('set null');
            $table->char('currency',4)->default('sar');
            $table->enum('transfer_status',['pending','transfered','refused'])->default('pending');
            $table->enum('transfer_type',['bank','wallet']);
            $table->string('transfer_fees');
            $table->text('refused_reason')->nullable();
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
        Schema::dropIfExists('transfered_balances');
    }
}
