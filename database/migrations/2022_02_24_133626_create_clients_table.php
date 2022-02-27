<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("Commercial_number")->unique();
            $table->string("tax_number")->unique();
            $table->string("bank_account_number")->unique();
            $table->string("phone")->unique()->nullable();
            $table->foreignUuid("bank_id")->constrained("banks")->onDelete("cascade");
            $table->string("activity_type");
            $table->string("operations_count");
            $table->string("tax_number")->unique();
            $table->string("nationality")->nullable();
            $table->string("address")->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('marital_status', ['married', 'single'])->nullable();
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
        Schema::dropIfExists('clients');
    }
}
