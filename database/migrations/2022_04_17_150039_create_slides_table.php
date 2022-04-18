<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(true);
            $table->string('ordering');
            $table->foreignUuid('added_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });

          Schema::create('slide_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('slide_id')->constrained('slides')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name',100);
            $table->text('description')->nullable();
            $table->unique(['slide_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(['slides','slide_translations']);
    }
}
