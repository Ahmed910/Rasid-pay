<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(true);
            $table->string('link')->nullable();
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('static_page_id')->constrained('static_pages')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->longText('description');
            $table->unique(['static_page_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('static_page_translations');
        Schema::dropIfExists('static_pages');
    }
}
