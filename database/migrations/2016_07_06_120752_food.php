<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Food extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->increments('id_food');
            $table->integer('id_vitamin')->unsigned();
            $table->text('title');
            $table->integer('milligrams_vitamin');
        });

        Schema::table('food', function($table) {
            $table->foreign('id_vitamin')->references('id_vitamin')->on('Vitamins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('food');
    }
}
