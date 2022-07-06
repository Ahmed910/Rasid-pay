<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTypesTable extends Migration
{
    public function up()
    {
        Schema::create('message_types', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('message_type_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('message_type_id')->constrained('message_types')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name', 100);

            $table->unique(['message_type_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('message_type_translations');
        Schema::dropIfExists('message_types');
    }
}
