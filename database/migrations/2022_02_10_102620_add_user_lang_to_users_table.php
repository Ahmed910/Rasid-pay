<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserLangToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid("department_id")->nullable()->constrained()->onDelete('set null');
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->onDelete('set null');
            $table->foreignUuid("country_id")->nullable()->constrained()->onDelete('set null');
            $table->char("user_locale", 3)->default('ar');
            $table->string("login_id")->nullable();
            $table->string("login_code")->nullable();
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
            $table->dropForeign('users_department_id_foreign');
            $table->dropForeign('users_country_id_foreign');
            $table->dropForeign('users_added_by_id_foreign');
            $table->dropColumn('department_id', 'user_locale', 'added_by_id', 'country_id', 'login_id', 'login_code');
        });
    }
}
