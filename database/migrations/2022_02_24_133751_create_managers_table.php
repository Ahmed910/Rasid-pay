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
            $table->foreignUuid("client_id")->nullable()->constrained("clients")->nullOnDelete();
            $table->string('manager_phone')->unique();
            $table->string('manager_email')->unique();
            $table->string("manager_identity_number")->unique();
            $table->string("manager_name");
            $table->string("manager_nationality")->nullable();
            $table->string("manager_address")->nullable();
            $table->enum('manager_gender', ['male', 'female'])->nullable();
            $table->enum('manager_marital_status', ['married', 'single'])->nullable();
            $table->date('manager_date_of_birth');
            $table->text("manager_elm_reply")->nullable();
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
