<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBanStatusToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('ban_status', ['active', 'permanent', 'temporary'])->default('active');
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->onDelete('set null');
            $table->foreignUuid("country_id")->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['country_id','added_by_id']);
            $table->dropColumn('added_by_id', 'country_id', 'ban_status');
        });
    }
}
