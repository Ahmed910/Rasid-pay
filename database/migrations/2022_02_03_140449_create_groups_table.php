<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('group_translations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("locale")->index();
            $table->foreignUuid("group_id")->constrained()->onDelete('cascade');
            $table->unique(["group_id", "locale"]);
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->foreignUuid("group_id")->constrained()->onDelete('cascade');
            $table->foreignUuid("user_id")->constrained()->onDelete('cascade');
            $table->primary(['group_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists("group_user");
        Schema::dropIfExists("group_translations");
        Schema::dropIfExists('groups');
    }
}
