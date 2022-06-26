<?php

use App\Models\Transfer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->decimal('transfer_fees')->default(0);
            $table->enum('transfer_type',Transfer::TRANSFER_TYPES);
            $table->string('transfer_status')->default('pending');
            $table->foreignUuid('transfer_purpose_id')->nullable()->constrained("transfer_purposes")->onDelete('set null');
            $table->enum('fee_upon',Transfer::FEE_UPON)->nullable();
            $table->unsignedbigInteger('transfer_number')->unique();
            $table->string('phone')->nullable();
            $table->enum('wallet_transfer_method',Transfer::WALLET_TRANSFER_METHODS)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->bigInteger('transfer_number', true, true)->change();
        });

        DB::update("ALTER TABLE transfers AUTO_INCREMENT = 10000;");
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
