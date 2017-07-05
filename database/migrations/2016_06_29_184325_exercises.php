<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Exercises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id_ex');
            $table->string('name');
            $table->integer('difficulty');
            $table->integer('category');
            $table->integer('id_type')->unsigned();

        });

        Schema::table('exercises', function($table) {
            $table->foreign('id_type')->references('id_type')->on('type_trains')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exercises');
    }
}
