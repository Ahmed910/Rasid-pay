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
            $table->uuidMorphs("auditable");
            $table->string("action_type");
            $table->string("old_data");
            $table->string("new_data");
            $table->ipAddress("ip_address");
            $table->string("agent");
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
        Schema::dropIfExists('activity_logs');
    }
}
