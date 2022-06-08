<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('bank_id')->nullable()->constrained('banks')->onDelete('set null');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('iban_number')->nullable();
            $table->enum('contract_type', ['pending', 'before_review', 'reviewed'])->default('pending');
            $table->unsignedbigInteger('order_number')->unique();
            $table->enum('account_status', ['pending', 'before_review', 'reviewed','accepted','refused'])->default('pending');
            $table->text('refused_reason')->nullable();
            $table->timestamps();
        });

        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->bigInteger('order_number', true, true)->change();
        });

        DB::update("ALTER TABLE bank_accounts AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}
