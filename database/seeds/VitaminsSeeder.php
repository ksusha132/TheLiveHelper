<?php

use Illuminate\Database\Seeder;

class VitaminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Vitamins')->insert([
            'id_vitamin' => '1',
            'name' => 'A',
            'norma_vitamin_female' => '600',
            'norma_vitamin_male' => '700',
        ]);

        DB::table('Vitamins')->insert([
            'id_vitamin' => '2',
            'name' => 'B',
            'norma_vitamin_female' => '1500',
            'norma_vitamin_male' => '2000',
        ]);

        DB::table('Vitamins')->insert([
            'id_vitamin' => '3',
            'name' => 'C',
            'norma_vitamin_female' => '110',
            'norma_vitamin_male' => '125',
        ]);

        DB::table('Vitamins')->insert([
            'id_vitamin' => '4',
            'name' => 'D',
            'norma_vitamin_female' => '2500',
            'norma_vitamin_male' => '2500',
        ]);

        DB::table('Vitamins')->insert([
            'id_vitamin' => '5',
            'name' => 'E',
            'norma_vitamin_female' => '50',
            'norma_vitamin_male' => '40',
        ]);
    }
}
