<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transfers', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('currency_id')->nullable()->constrained("countries")->onDelete('set null');
            $table->foreignUuid('to_currency_id')->nullable()->constrained("countries")->onDelete('set null');
            $table->foreignUuid('beneficiary_id')->nullable()->constrained("beneficiaries")->onDelete('set null');
            $table->foreignUuid('recieve_option_id')->nullable()->constrained("recieve_options")->onDelete('set null');
            $table->foreignUuid('transfer_id')->nullable()->constrained("transfers")->onDelete('cascade');
            $table->enum('balance_type',['pay','back']);
            $table->string('mtcn_number')->nullable();
            $table->float('exchange_rate')->nullable();
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
        Schema::dropIfExists('bank_transfers');
    }
}
