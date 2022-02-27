<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string("identity_number")->unique();
            $table->string("name");
            $table->string("nationality")->nullable();
            $table->string("address")->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('marital_status', ['married', 'single'])->nullable();
            $table->date('date_of_birth');
            $table->text("elm_reply")->nullable() ;
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
        Schema::dropIfExists('managers');
    }
}
