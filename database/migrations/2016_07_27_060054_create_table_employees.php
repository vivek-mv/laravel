<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create employees table
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix',4);
            $table->string('firstName',20);
            $table->string('middleName',20)->nullable();
            $table->string('lastName',20)->nullable();
            $table->string('gender',6);
            $table->date('dob');
            $table->string('mobile',11)->nullable();
            $table->string('landline',11)->nullable();
            $table->string('email',50);
            $table->string('password',100);
            $table->string('maritalStatus',10);
            $table->string('employment',11);
            $table->string('employer',25)->nullable();
            $table->string('photo',30)->nullable();
            $table->string('note',150)->nullable();
            $table->string('roleId',11)->default('1');
            $table->string('stackId',11)->default('0');
            $table->string('remember_token')->nullable();
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
        Schema::drop('employees');
    }
}
