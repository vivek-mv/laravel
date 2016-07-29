<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRoleResourcePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create Role Resource Permission table
        Schema::create('role_resource_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();;
            $table->integer('resource_id')->unsigned();;
            $table->integer('permission_id')->unsigned();;
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('resource_id')->references('id')->on('resources');
            $table->foreign('permission_id')->references('id')->on('permissions');
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
        Schema::drop('role_resource_permission');
    }
}
