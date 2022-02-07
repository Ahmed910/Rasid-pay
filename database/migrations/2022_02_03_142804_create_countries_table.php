<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->softDeletes();
            $table->string('phone_code');
            $table->timestamps();
        });

        Schema::create('country_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('locale')->index();
            $table->string('name');
            $table->string('nationality');
            $table->string('currency');

            $table->unique(['country_id', 'locale']);
            $table->foreignUuid('country_id')->constrained("countries");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
