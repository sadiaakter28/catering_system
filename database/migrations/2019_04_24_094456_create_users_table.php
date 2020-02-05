<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name', 32);
            $table->string('username', 32);
            $table->string('password', 128);
            $table->string('email',64);
            $table->text('address');
            $table->string('phone', 32);
            $table->string('user_type', 32)->default('user');
            $table->float('balance',8,2);
            //$table->string('remember_token', 128)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
}
