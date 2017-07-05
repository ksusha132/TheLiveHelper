<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->increments('id_set');
            $table->integer('set_num');
            $table->integer('reps');
            $table->integer('weight');
            $table->integer('id_train')->unsigned();
            $table->integer('id_ex')->unsigned();

        });

        Schema::table('sets', function($table) {
            $table->foreign('id_train')->references('id_train')->on('trains')->onDelete('cascade');
            $table->foreign('id_ex')->references('id_ex')->on('exercises')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sets');
    }
}
