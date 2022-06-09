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
            $table->foreignUuid("from_user_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignUuid("to_user_id")->nullable()->constrained('users')->nullOnDelete();

            // $table->foreignUuid("wallet_charge_id")->nullable()->constrained("wallet_charges")->nullOnDelete();
            // $table->foreignUuid("payment_id")->nullable()->constrained("payments")->nullOnDelete();
            // $table->foreignUuid("transfer_id")->nullable()->constrained("transfers")->nullOnDelete();
            // $table->foreignUuid("money_request_id")->nullable()->constrained("money_requests")->nullOnDelete();

            $table->nullableUuidMorphs("transactionable"); //wallet_charges - transfers - payments - money_requests

            $table->foreignUuid("bank_id")->nullable()->constrained("banks")->nullOnDelete();
            $table->foreignUuid("bank_branch_id")->nullable()->constrained("bank_branches")->nullOnDelete();
            $table->foreignUuid("citizen_package_id")->nullable()->constrained("citizen_packages")->nullOnDelete();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_data')->nullable();
            $table->unsignedbigInteger('trans_number')->unique();
            $table->enum('trans_type', ['pay', 'transfer', 'charge', 'money_request']);
            $table->string("qr_path")->nullable();
            $table->string('amount');
            $table->string('fee_amount')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('trans_number', true, true)->change();
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
