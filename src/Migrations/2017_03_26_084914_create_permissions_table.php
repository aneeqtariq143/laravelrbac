<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->unsigned()->index('roles_parent_id');
            $table->string('name', 50);
            $table->string('display_name', 100);
            $table->string('description', 255)->nullable();
            $table->enum('type', ['expand', 'open', 'button'])->comment('Expands always be Parent (Category) and Open can be links (Permissions)');
            $table->string('url', 255)->nullable();
            $table->string('parameters', 255)->nullable();
            $table->string('url_query_string', 255)->nullable();
            $table->string('css_class', 50)->nullable();
            $table->boolean('main_menu');
            $table->smallInteger('sort_no')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')->references('id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('permissions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
