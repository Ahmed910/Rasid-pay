<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizenPackagePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizen_package_promo_codes', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("promo_code")->unique();
            $table->foreignUuid("citizen_package_id")->nullable()->constrained("citizen_packages")->OnDelete('set null');
            $table->string('promo_discount',30)->nullable();
            $table->boolean('is_used')->default(false);
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
        Schema::dropIfExists('citizen_promo_codes');
    }
}
