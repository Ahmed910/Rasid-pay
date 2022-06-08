<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('citizen_id')->nullable()->constrained('citizens')->onDelete('set null');
            $table->string('invoice_number');
            $table->decimal('amount',12,2);
            $table->text('description')->nullable();
            $table->enum('payment_type',['nfc','manual'])->default('manual');
            $table->text('payment_data')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
