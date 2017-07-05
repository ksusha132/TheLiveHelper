<?php

use Illuminate\Database\Seeder;

class SleepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_of_sleep')->insert([
            'id_type_of_sleep' => '1',
            'sleep_name' => 'good',
        ]);
        DB::table('type_of_sleep')->insert([
            'id_type_of_sleep' => '2',
            'sleep_name' => 'not very good',
        ]);
        DB::table('type_of_sleep')->insert([
            'id_type_of_sleep' => '3',
            'sleep_name' => 'very good',
        ]);
        DB::table('type_of_sleep')->insert([
            'id_type_of_sleep' => '4',
            'sleep_name' => 'I could not sleep',
        ]);
        DB::table('type_of_sleep')->insert([
            'id_type_of_sleep' => '5',
            'sleep_name' => 'very bad',
        ]);
    }
}
