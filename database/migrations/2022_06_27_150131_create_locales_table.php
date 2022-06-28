<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalesTable extends Migration
{
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('key');
            $table->string('file')->nullable();
            $table->timestamps();
        });

        Schema::create('locale_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('locale_id')->constrained('locales')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('value');
            $table->text('desc')->nullable();
            $table->unique(['locale_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('locales');
    }
}
