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
            $table->boolean('is_active')->default(false);
            $table->boolean('is_admin_active_user')->default(true);
            $table->boolean('is_ban')->default(false)->nullable();
            $table->text('ban_reason')->nullable();
            $table->string('reset_code')->nullable();
            $table->string('verified_code')->nullable();
            $table->string('identity_number')->nullable();
            $table->enum('register_status',['pending','inprogress','completed'])->default('pending');
            $table->enum('user_type',['admin' , 'superadmin' , 'client'])->nullable(); 
            $table->enum('client_type',['company' , 'Institution' , 'member' , 'freelance_doc' , 'famous' , 'other'])->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->float('rate_avg',5,2)->default(0);
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_birth_hijri')->nullable();
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
