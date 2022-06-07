<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferPurposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_purposes', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('transfer_purpose_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('transfer_purpose_id')->constrained("transfer_purposes")->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('locale')->index();
            $table->unique(['transfer_purpose_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_purposes');
    }
}
