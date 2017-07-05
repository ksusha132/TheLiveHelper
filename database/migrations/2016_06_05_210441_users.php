<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('login');
            $table->string('password');
            $table->integer('height');
            $table->integer('weight');
            $table->integer('muscle_weight');
            $table->integer('active_nuclear_weight');
            $table->enum('sex', ['female', 'male']);
            $table->text('achivements');
            $table->text('current_goal');
            $table->string('photo',255);
            $table->integer('age');
            $table->text('education');
            $table->integer('desired_weight');
            $table->rememberToken();
            $table->boolean('activated')->default(0);
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
        Schema::drop('users');
    }
}
