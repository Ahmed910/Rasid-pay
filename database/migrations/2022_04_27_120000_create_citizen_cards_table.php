<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizenCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizen_cards', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("card_package_id")->constrained("card_packages")->OnDelete('set null')->nullable();
            $table->foreignUuid("citizen_id")->constrained("users")->OnDelete('set null')->nullable();
            $table->string("card_price")->nullable();
            $table->text("card_data")->nullable();
            $table->date("start_at")->nullable();
            $table->date("end_at")->nullable();
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
        Schema::dropIfExists('citizen_cards');
    }
}
