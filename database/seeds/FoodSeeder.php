<?php

use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('food')->insert([
            'id_food' => '1',
            'title' => 'orange',
            'id_vitamin' => '3',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '2',
            'title' => 'milk',
            'id_vitamin' => '1',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '3',
            'title' => 'cheese',
            'id_vitamin' => '4',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '4',
            'title' => 'bred',
            'id_vitamin' => '5',
            'milligrams_vitamin' => '100',
        ]);

        DB::table('food')->insert([
            'id_food' => '6',
            'title' => 'rise',
            'id_vitamin' => '1',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '7',
            'title' => 'buckwheat',
            'id_vitamin' => '2',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '8',
            'title' => 'chicken',
            'id_vitamin' => '3',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '9',
            'title' => 'fish',
            'id_vitamin' => '4',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '10',
            'title' => 'potato',
            'id_vitamin' => '5',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '11',
            'title' => 'turkey',
            'id_vitamin' => '2',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '12',
            'title' => 'beaf',
            'id_vitamin' => '3',
            'milligrams_vitamin' => '100',
        ]);
        DB::table('food')->insert([
            'id_food' => '13',
            'title' => 'pork',
            'id_vitamin' => '2',
            'milligrams_vitamin' => '100',
        ]);
    }
}
