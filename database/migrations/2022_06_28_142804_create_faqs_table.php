<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(1);
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('faq_id')->constrained("faqs")->onDelete('cascade');
            $table->text('question');
            $table->longText('answer');
            $table->string('locale')->index();
            $table->unique(['faq_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
}
