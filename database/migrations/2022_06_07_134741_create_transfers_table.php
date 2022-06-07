<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('from_user_id')->nullable()->constrained("users")->onDelete('set null');
            $table->foreignUuid('to_user_id')->nullable()->constrained("users")->onDelete('set null');
            $table->decimal('amount',12,2);
            $table->decimal('transfer_fees');
            $table->enum('transfer_type',['wallet','local','global']);
            $table->string('transfer_status')->default('pending');
            $table->decimal('fee_upon')->default(0);
            $table->unsignedbigInteger('transfer_number')->unique();
            $table->string('phone')->nullable();
            $table->enum('wallet_transfer_method',['phone','identity_number','wallet_number'])->nullable();
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
        Schema::dropIfExists('transfers');
    }
}
