<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fullname');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->unique();
            $table->string('whatsapp')->nullable();
            $table->boolean('is_password_changed')->default(false)->comment('check if user changed password for first time');
            $table->boolean('is_login_code')->default(false)->comment('send verification code every time login');
            $table->boolean('is_active')->default(false)->comment('check phone is verified');
            $table->boolean('is_ban')->default(false)->comment('change status to ban');
            $table->text('ban_reason')->nullable();
            $table->boolean('is_ban_always')->nullable()->comment('1=always,0=period');
            $table->date('ban_from')->nullable();
            $table->date('ban_to')->nullable();
            $table->string('reset_code')->nullable();
            $table->string('verified_code')->nullable();
            $table->string('identity_number')->nullable();
            $table->enum('register_status', ['pending', 'inprogress', 'completed'])->default('pending');
            $table->enum('user_type', ['employee', 'admin', 'superadmin', 'client']);
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->float('rate_avg', 5, 2)->default(0);
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_birth_hijri')->nullable();
            $table->boolean('is_date_hijri')->default(false)->comment('1 if user want to show hijri date');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
