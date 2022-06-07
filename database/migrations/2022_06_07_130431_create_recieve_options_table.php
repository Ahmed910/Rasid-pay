<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecieveOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recieve_options', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('recieve_option_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('recieve_option_id')->constrained("recieve_options")->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('locale')->index();
            $table->unique(['recieve_option_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(['recieve_options','recieve_option_translations']);


    }
}
