<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignUuid("role_id")->constrained()->onDelete('cascade');
            $table->foreignUuid("permission_id")->constrained()->onDelete('cascade');

            $table->primary(['role_id', 'permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
}
