<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactRepliesTable extends Migration
{
    public function up()
    {
        Schema::create('contact_replies', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("contact_id")->constrained("contacts")->cascadeOnDelete();
            $table->foreignUuid("admin_id")->nullable()->constrained("users")->nullOnDelete();
            $table->longText("reply");
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_replies');
    }
}
