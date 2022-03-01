<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddedByIdToModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('rasid_jobs', function (Blueprint $table) {
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign('groups_added_by_id_foreign');
            $table->dropColumn('added_by_id');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign('departments_added_by_id_foreign');
            $table->dropColumn('added_by_id');
        });

        Schema::table('rasid_jobs', function (Blueprint $table) {
            $table->dropForeign('rasid_jobs_added_by_id_foreign');
            $table->dropColumn('added_by_id');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign('countries_added_by_id_foreign');
            $table->dropColumn('added_by_id');
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->dropForeign('currencies_added_by_id_foreign');
            $table->dropColumn('added_by_id');
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->dropForeign('regions_added_by_id_foreign');
            $table->dropColumn('added_by_id');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign('cities_added_by_id_foreign');
            $table->dropColumn('added_by_id');
        });

    }
}
