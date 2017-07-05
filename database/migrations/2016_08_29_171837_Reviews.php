<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Reviews', function (Blueprint $table) {
            $table->increments('id_review');
            $table->integer('id_trainer')->unsigned(); // user::id
            $table->integer('id_user')->unsigned(); // Auth::user()
            $table->text('review');
            $table->timestamps();
        });

        Schema::table('Reviews', function ($table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_trainer')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Reviews');
    }
}
