<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_package', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("client_id")->nullable()->constrained("users")->OnDelete('set null');
            $table->foreignUuid("package_id")->nullable()->constrained("packages")->OnDelete('set null');
            $table->string('package_discount')->nullable();
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
        Schema::dropIfExists('client_package');
    }
}
