<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sleep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sleep', function (Blueprint $table) {
            $table->increments('id_sleep');
            $table->time('time_start_sleep');
            $table->time('time_end_sleep');
            $table->text('pleasure');
            $table->date('date');
            $table->integer('id_type_of_sleep')->unsigned();
            $table->integer('id_user')->unsigned();

        });

        Schema::table('sleep', function($table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_type_of_sleep')->references('id_type_of_sleep')->on('type_of_sleep')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sleep');
    }
}
