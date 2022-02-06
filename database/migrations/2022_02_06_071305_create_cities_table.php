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
//            $table
            $table->string("name")  ;
            $table->foreignUuid("region_id") ;
            $table->foreignUuid("country_id") ;
            $table ->string ("region") ;
            $table ->string("postal_code")  ;
            $table->softDeletes() ;
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
        Schema::dropIfExists('cities');
    }
}
