<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vitamins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Vitamins', function (Blueprint $table) {
            $table->increments('id_vitamin');
            $table->text('name');
            $table->integer('norma_vitamin_female');
            $table->integer('norma_vitamin_male');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Vitamins');
    }
}
