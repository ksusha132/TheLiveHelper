<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Eaten extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eaten', function (Blueprint $table) {
            $table->increments('id_eaten');
            $table->integer('calories');
            $table->integer('gramm');
            $table->integer('id_meal')->unsigned();
            $table->integer('id_food')->unsigned();

        });

        Schema::table('eaten', function($table) {
            $table->foreign('id_food')->references('id_food')->on('food')->onDelete('cascade');
            $table->foreign('id_meal')->references('id_meal')->on('meals')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('eaten');
    }
}
