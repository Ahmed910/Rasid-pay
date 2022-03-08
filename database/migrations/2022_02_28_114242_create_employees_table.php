<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignUuid('rasid_job_id')->nullable()->constrained('rasid_jobs')->onDelete('set null');
            $table->enum('contract_type', ['salary', 'salary_with_percent', 'percent'])->default('salary');
            $table->float('salary', 10, 2)->nullable();
            $table->string('qr_path')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
