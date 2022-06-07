<?php

use App\Models\CardPackage\CardPackage;
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
            $table->foreignUuid("citizen_package_id")->nullable()->constrained("users")->OnDelete('set null');
            $table->enum("card_type", CardPackage::CARD_TYPES)->default(CardPackage::BASIC);
            $table->string("card_price")->nullable();
            $table->string("upgrade_price")->nullable();
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
        Schema::dropIfExists('citizen_packages');
    }
}
