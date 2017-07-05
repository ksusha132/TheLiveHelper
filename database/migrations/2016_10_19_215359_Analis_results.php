<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnalisResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Analis_results', function (Blueprint $table) {
            $table->increments('id_results');
            $table->integer('id_analis')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->float('input_user_analis',8,3);
            $table->timestamps();
        });

        Schema::table('Analis_results', function($table) {
            $table->foreign('id_analis')->references('id_analis')->on('Analis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Analis_results');
    }
}
