<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTypeUserTable extends Migration
{
    public function up()
    {
        Schema::create('message_type_user', function (Blueprint $table) {
            $table->foreignUuid('admin_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('message_type_id')->constrained('message_types')->onDelete('cascade');
            $table->unique(['admin_id', 'message_type_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('message_type_user');
    }
}
