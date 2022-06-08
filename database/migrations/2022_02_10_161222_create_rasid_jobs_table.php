<?php

use App\Models\RasidJob\RasidJob;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRasidJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rasid_jobs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignUuid("added_by_id")->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_vacant')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('rasid_job_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rasid_job_id')->constrained('rasid_jobs')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name',100);
            $table->text('description')->nullable();

            $table->unique(['rasid_job_id', 'locale']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rasid_job_translations');
        Schema::dropIfExists('rasid_jobs');
    }
}
