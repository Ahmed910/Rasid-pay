<?php

use App\Models\Transaction;
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
//            $table->foreignUuid("bank_branch_id")->nullable()->constrained("bank_branches")->nullOnDelete();
//            $table->foreignUuid("citizen_package_id")->nullable()->constrained("citizen_packages")->nullOnDelete();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_data')->nullable();
            $table->unsignedbigInteger('trans_number')->unique();
            $table->enum('trans_type', Transaction::TRANACTION_TYPES);
            $table->enum('trans_status', Transaction::TYPES);
            $table->string("qr_path")->nullable();
            $table->string('amount');
            $table->string('fee_amount')->default(0);
            $table->string('summary_path')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
}
