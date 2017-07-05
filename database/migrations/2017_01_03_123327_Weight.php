 <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Weight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Weight', function (Blueprint $table) {
            $table->increments('id_weight');
            $table->integer('id_user')->unsigned();
            $table->float('weight');
            $table->date('date');

        });

        Schema::table('Weight', function($table) {
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
        Schema::drop('Weight');
    }
}
