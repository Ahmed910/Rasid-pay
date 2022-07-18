<?php

use App\Models\Vendor\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('vendor_packages', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('basic_discount');
            $table->string('golden_discount');
            $table->string('platinum_discount');

            $table->foreignIdFor(Vendor::class)->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_packages');
    }
}
