<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("card_package_id")->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('number')->unique();
            $table->string('amount');
            $table->string("user_identity")->nullable();
            $table->enum('status', ['success', 'fail', 'pending', 'received', 'cancel'])->default('pending');
            $table->enum('type', ['payment', 'wallet_transfer', 'bank_transactoin', 'receive_credit', 'recharge_credit', 'upgrade_card'])->default('payment');
            $table->string("action_type")->nullable();
            $table->string("to_user_id")->nullable();
            $table->string("to_user_identity")->nullable();
            $table->string("qr_code")->nullable();

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('number', true, true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
