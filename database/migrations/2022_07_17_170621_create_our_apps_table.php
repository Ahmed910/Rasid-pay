<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_apps', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->integer('order')->default(1);
            $table->boolean('is_active')->default(1);
            $table->string('android_link');
            $table->string('ios_link');
            $table->timestamps();
        });

        Schema::create('our_app_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('our_app_id')->constrained('our_apps')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name', 100);
            $table->longText('description')->nullable();

            $table->unique(['our_app_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('our_app_translations');
        Schema::dropIfExists('our_apps');
    }
}
