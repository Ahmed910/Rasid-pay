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
            $table->foreignUuid("user_id")->constrained("users")->onDelete("cascade");
            $table->foreignUuid("manager_id")->constrained("managers")->onDelete("null");
            $table->enum('client_type', ['company', 'institution', 'member', 'freelance_doc', 'famous', 'other'])->default("company");
            $table->string("Commercial_number")->unique();
            $table->string("tax_number")->unique();
            $table->string("activity_type");
            $table->integer("daily_expect_trans");
            $table->string("nationality")->nullable();
            $table->string("address")->nullable();
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
