<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_group', function (Blueprint $table) {
            $table->foreignUuid("first_group_id")->constrained('groups')->onDelete('cascade');
            $table->foreignUuid("second_group_id")->constrained('groups')->onDelete('cascade');
            $table->primary(['first_group_id', 'second_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_group');
    }
}
