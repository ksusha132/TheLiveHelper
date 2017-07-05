<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Message extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Message', function (Blueprint $table) {
            $table->increments('id_message');
            $table->integer('id_conversation')->unsigned();
            $table->text('message');
            $table->integer('id_user')->unsigned(); // foreign key user and another user
            $table->timestamps();
        });
        Schema::table('Message', function($table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_conversation')->references('id_conversation')->on('conversations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Message');
    }
}
