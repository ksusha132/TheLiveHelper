<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;
use App\trains;

class TainerToTrain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_to_train', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_trainer')->unsigned();
            $table->integer('id_train')->unsigned();
        });

        Schema::table('trainer_to_train', function ($table) {
            $table->foreign('id_trainer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_train')->references('id_train')->on('trains')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer_to_train');
    }
}
