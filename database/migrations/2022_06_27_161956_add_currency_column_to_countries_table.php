<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addCurrencyColumnToCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->char('currency_code',5)->nullable()->after('phone_code');
        });
        Schema::table('country_translations', function (Blueprint $table) {
            $table->string('currency')->nullable()->after('name');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('currency_code');
        });
        Schema::table('country_translations', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
}
