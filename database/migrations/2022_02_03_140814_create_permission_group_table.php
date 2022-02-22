<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionGroupTable extends Migration
{
    public function up()
    {
        Schema::create('permission_group', function (Blueprint $table) {
            $table->foreignUuid("group_id")->constrained()->onDelete('cascade');
            $table->foreignUuid("permission_id")->constrained()->onDelete('cascade');
            $table->primary(['group_id', 'permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_group');
    }
}
