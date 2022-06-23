<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVueDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vue_domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->string('domain_type')->nullable();//test - live
            $table->boolean('is_active')->default(true);
            $table->char('version',15);
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
        Schema::dropIfExists('vue_domains');
    }
}
