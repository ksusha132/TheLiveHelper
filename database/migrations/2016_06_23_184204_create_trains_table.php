<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->increments('id_train');
            $table->time('timestart');
            $table->time('timeend');
            $table->integer('average_pulse');
            $table->date('date');
            $table->integer('id_user')->unsigned();
            $table->integer('id_type')->unsigned();

        });

        Schema::table('trains', function($table) {
            $table->foreign('id_type')->references('id_type')->on('type_trains')->onDelete('cascade');
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
        Schema::drop('trains');
    }
}
