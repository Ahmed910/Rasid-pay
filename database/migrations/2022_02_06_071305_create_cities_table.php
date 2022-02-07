<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->foreignUuid("region_id");
            $table->string("postal_code");
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('city_translations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('city_id')->constrained("cities")->onDelete("cascade");
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['city_id', 'locale']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_translations');
        Schema::dropIfExists('cities');
    }
}
