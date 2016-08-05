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
            $table->string('firstName',11);
            $table->string('middleName',11)->nullable();
            $table->string('lastName',11)->nullable();
            $table->string('gender',6);
            $table->date('dob');
            $table->string('mobile',10)->nullable();
            $table->string('landline',10)->nullable();
            $table->string('email',50);
            $table->string('password',100);
            $table->string('maritalStatus',10);
            $table->string('employment',11);
            $table->string('employer',25)->nullable();
            $table->string('photo',30)->nullable();
            $table->string('note',150)->nullable();
            $table->string('roleId',1)->default('1');
            $table->string('stackId',100)->default('0');
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
