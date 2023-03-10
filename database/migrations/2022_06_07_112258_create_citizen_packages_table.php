<?php

use App\Models\Package\Package;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizenPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizen_packages', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("citizen_id")->nullable()->constrained("users")->OnDelete('set null');
            $table->enum('package_type', ['basic', 'golden', 'platinum'])->default('basic');
            $table->string('package_price')->nullable();
            $table->date("start_at")->nullable();
            $table->date("end_at")->nullable();
            $table->string('promo_code')->nullable();
            $table->string('promo_discount',30)->nullable();
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
        Schema::dropIfExists('citizen_packages');
    }
}
