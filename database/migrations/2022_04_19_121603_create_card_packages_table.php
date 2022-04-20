<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_packages', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(true);
            $table->integer('ordering');
            $table->string('price');
            $table->string('offer')->nullable();
            $table->string('color', 20)->nullable();
            $table->boolean('available_for_promo')->default(true);
            $table->string('cash_back');
            $table->string('promo_cash_back');
            $table->string('discount_promo_code');
            $table->foreignUuid('added_by_id')->nullable()->constrained('users')->onDelete('set null');

            $table->softDeletes();

            $table->timestamps();
        });


        Schema::create('card_package_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('card_package_id')->constrained('card_packages')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['card_package_id', 'locale']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_package_translations');
        Schema::dropIfExists('card_packages');
    }
}
