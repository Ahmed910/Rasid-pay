<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_manager', function (Blueprint $table) {
            Schema::create('manager_user', function (Blueprint $table) {
                $table->foreignUuid("manager_id")->constrained()->onDelete('cascade');
                $table->foreignUuid("user_id")->constrained()->onDelete('cascade');
                $table->primary(['manager_id', 'manager_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_manager');
    }
}
