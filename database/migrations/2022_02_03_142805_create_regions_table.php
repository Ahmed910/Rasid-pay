<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('country_id')->constrained('countries')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('region_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('region_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['region_id', 'locale']);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_translations');
        Schema::dropIfExists('regions');
    }
}
