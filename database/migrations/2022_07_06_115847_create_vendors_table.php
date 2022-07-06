<?php

use App\Models\Vendor\Vendor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->enum('type', Vendor::TYPES);
            $table->string('commercial_record');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('tax_number');
            $table->string('iban');
            $table->boolean('is_support_maak');
            $table->boolean('is_active');
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('vendor_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name', 100);

            $table->unique(['vendor_id', 'locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_translations');
        Schema::dropIfExists('vendors');
    }
}
