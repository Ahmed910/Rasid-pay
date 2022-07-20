<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessagesCountColumnToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('messages_count')->default(0);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->foreignUuid("assigned_to_id")->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('messages_count');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['assigned_to_id']);
            $table->dropColumn('assigned_to_id');
        });
    }
}
