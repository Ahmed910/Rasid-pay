<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->foreignUuid("package_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid("to_user_id")->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid("from_user_id")->constrained("users")->onDelete("cascade");
            $table->foreignUuid("bank_id")->nullable()->constrained("banks")->OnDelete('set null');

            // $table->foreignUuid("client_id")->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedbigInteger('number')->unique();
            $table->string('amount');
            $table->string("user_identity")->nullable();
            $table->enum('status', ['success', 'fail', 'pending', 'received', 'cancel'])->default('pending');
            $table->enum('type', ['payment', 'wallet_transfer', 'bank_transaction', 'receive_credit', 'wallet_charge', 'upgrade_card'])->default('payment');
            $table->string("action_type")->nullable();
            $table->string("to_user_identity")->nullable();
            $table->string("transaction_id")->nullable()->unique();
            $table->text("transaction_data")->nullable();
            $table->string("qr_code")->nullable();
            $table->string("total_amount")->default(0);
            $table->string("main_balance")->default(0);
            $table->string("gift_balance")->default(0);
            $table->string("discount_percent")->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('number', true, true)->change();
        });

        DB::update("ALTER TABLE transactions AUTO_INCREMENT = 10000;");
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
