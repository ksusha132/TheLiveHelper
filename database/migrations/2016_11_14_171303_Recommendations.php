<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Recommendations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Recommendations', function (Blueprint $table) {
            $table->increments('id_recommendation');
            $table->integer('id_user')->unsigned();
            $table->date('date_start_programm')->format('Y-m-d');
            $table->date('date_end_programm')->format('Y-m-d');
            $table->integer('weight_start');
            $table->integer('muscle_weight_start');
            $table->integer('active_nuclear_weight_start');
            $table->integer('goal');
            $table->text('content');
            $table->boolean('useful')->default(0);
        });

        Schema::table('Recommendations', function ($table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Recommendations');
    }
}
