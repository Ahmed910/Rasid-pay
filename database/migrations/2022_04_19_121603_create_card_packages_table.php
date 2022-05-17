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
            $table->string('basic_discount')->nullable();
            $table->string('golden_discount')->nullable();
            $table->string('platinum_discount')->nullable();
            $table->foreignUuid("client_id")->nullable()->constrained("users")->OnDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('card_package_translations');
        Schema::dropIfExists('card_packages');
    }
}
