<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->string("action_type") ;
            $table->string("olddata") ;
            $table->string("newdata") ;
            $table->ipAddress("ip address") ;
            $table->string("agent") ;
            $table->softDeletes() ;
            $table->timestamps();
            $table->index(["action_type" , "olddata" , "newdata" , "ip address" , "agent" ]) ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
