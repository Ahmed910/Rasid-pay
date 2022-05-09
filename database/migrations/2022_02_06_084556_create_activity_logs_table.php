<?php

use App\Models\ActivityLog;
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
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->nullableUuidMorphs("auditable");
            $table->string('sub_program')->nullable();
            $table->enum("action_type", ActivityLog::EVENTS);
            $table->text("old_data")->nullable();
            $table->text("new_data")->nullable();
            $table->text('search_params')->nullable();
            $table->ipAddress("ip_address");
            $table->string("agent");
            $table->text("url");
            $table->text("reason")->nullable();
            $table->string("user_type")->nullable();
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
