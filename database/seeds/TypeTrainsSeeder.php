<?php

use Illuminate\Database\Seeder;

class TypeTrainsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_trains')->insert([
            'id_type' => '1',
            'type_name' => 'legs',
        ]);

        DB::table('type_trains')->insert([
            'id_type' => '2',
            'type_name' => 'back',
        ]);

        DB::table('type_trains')->insert([
            'id_type' => '3',
            'type_name' => 'chest',
        ]);

        DB::table('type_trains')->insert([
            'id_type' => '4',
            'type_name' => 'stomach',
        ]);

        DB::table('type_trains')->insert([
            'id_type' => '5',
            'type_name' => 'hands',
        ]);

        DB::table('type_trains')->insert([
            'id_type' => '6',
            'type_name' => 'neck',
        ]);
    }
}
