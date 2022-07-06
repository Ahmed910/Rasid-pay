<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageTypeIdToMessageTypes extends Migration
{
    public function up()
    {
        Schema::table('message_types', function (Blueprint $table) {
            $table->foreignUuid("message_type_id")->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('message_types', function (Blueprint $table) {
            $table->dropColumn('message_type_id');
        });
    }
}
