<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferRelationsTable extends Migration
{
    public function up()
    {
        Schema::create('transfer_relations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('transfer_relation_translations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('transfer_relation_id')->constrained("transfer_relations")->onDelete("cascade");
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['transfer_relation_id', 'locale'], 'transfer_relation_unique_key');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfer_relation_translations');
        Schema::dropIfExists('transfer_relations');
    }
}
