<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Analis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Analis', function (Blueprint $table) {
            $table->increments('id_analis');
            $table->text('name_analis');
            $table->float('norma_analis_male_min',8,3);
            $table->float('norma_analis_male_max',8,3);
            $table->float('norma_analis_female_min',8,3);
            $table->float('norma_analis_female_max',8,3);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Analis');
    }
}
