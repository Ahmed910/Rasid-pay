<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('price')->default(0);
            $table->string('color')->nullable();
            $table->string('discount')->default(0);
            $table->string('duration')->nullable()->comment('by months');
            $table->tinyInteger('number_of_used')->nullable();
            $table->string('promo_discount')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('has_promo')->default(false);
            $table->boolean('is_default')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('package_translations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('package_id')->constrained("packages")->onDelete("cascade");
            $table->string('name');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['package_id', 'locale']);
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
        Schema::dropIfExists('package_translations');
        Schema::dropIfExists('packages');
    }
}
