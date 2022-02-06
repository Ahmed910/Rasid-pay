<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid("id")->primary();

            $table->timestamps();
        });

        Schema::create('role_translations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name")->unique();
            $table->string("locale")->index();
            $table->foreignUuid("role_id")->constrained();

            $table->unique(["name", "locale"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists("role_translations");
        Schema::dropIfExists('roles');
    }
}
