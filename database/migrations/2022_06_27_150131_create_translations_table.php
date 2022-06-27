<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('key');
            $table->text('value');
            $table->string('file')->nullable();
            $table->char('locale', 3)->default(app()->getLocale());
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
