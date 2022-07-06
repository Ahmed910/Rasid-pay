<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_branches', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("vendor_id")->constrained()->onDelete("cascade");
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('location')->nullable();
            $table->string('address_details')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
        Schema::create('vendor_branch_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('vendor_branch_id')->constrained('vendor_branches')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name',100);

            $table->unique(['vendor_branch_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_branches');
        Schema::dropIfExists('vendor_branch_translations');
    }
}
