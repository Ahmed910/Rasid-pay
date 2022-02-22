<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->foreignUuid('parent_id')->nullable()->constrained('departments')->onDelete('set null');
        });

        Schema::create('department_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name',100);
            $table->text('description')->nullable();

            $table->unique(['department_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_translations');
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign('departments_parent_id_foreign');
            $table->dropColumn('parent_id');
        });
        Schema::dropIfExists('departments');
    }
}
