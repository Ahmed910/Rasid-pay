<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('icon')->nullable();
            $table->string('uri')->nullable();
            $table->string('menu_type')->nullable();//erp_dashbord , client_dashboard , ....
            $table->integer('order')->nullable();
            $table->timestamps();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->foreignUuid('parent_id')->nullable()->constrained('menus')->onDelete('cascade');
        });

        Schema::create('menu_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['menu_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_translations');
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign('menus_parent_id_foreign');
            $table->dropColumn('parent_id');
        });
        Schema::dropIfExists('menus');
    }
}
