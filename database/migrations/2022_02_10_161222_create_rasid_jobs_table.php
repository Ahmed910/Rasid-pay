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
            $table->boolean('is_active')->default(1);
            $table->boolean('is_vacant')->default(1);
            $table->softDeletes();

            $table->timestamps();
        });


        Schema::create('rasid_job_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rasid_jobs_id')->constrained('rasid_jobs')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description');

            $table->unique(['rasid_jobs_id', 'locale']);
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
