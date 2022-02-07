<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->float('value', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('currency_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('currency_id')->constrained('currencies')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['currency_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_translations');
        Schema::dropIfExists('currencies');
    }
}
