<?php

use Illuminate\Database\Seeder;

class AnalisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Analis')->insert([
            'id_analis' => '1',
            'name_analis' => 'gemoglobin',
            'norma_analis_male_min' => '130',
            'norma_analis_male_max' => '170',
            'norma_analis_female_min' => '120',
            'norma_analis_female_max' => '150',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '2',
            'name_analis' => 'eretrocits',
            'norma_analis_male_min' => '4',
            'norma_analis_male_max' => '5',
            'norma_analis_female_min' => '3.5',
            'norma_analis_female_max' => '4.7',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '3',
            'name_analis' => 'leicocits',
            'norma_analis_male_min' => '4',
            'norma_analis_male_max' => '9',
            'norma_analis_female_min' => '4',
            'norma_analis_female_max' => '9',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '4',
            'name_analis' => 'gematocrit',
            'norma_analis_male_min' => '42',
            'norma_analis_male_max' => '50',
            'norma_analis_female_min' => '38',
            'norma_analis_female_max' => '47',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '5',
            'name_analis' => 'trombocits',
            'norma_analis_male_min' => '180',
            'norma_analis_male_max' => '320',
            'norma_analis_female_min' => '180',
            'norma_analis_female_max' => '320',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '6',
            'name_analis' => 'speed down eretrocits',
            'norma_analis_male_min' => '3',
            'norma_analis_male_max' => '10',
            'norma_analis_female_min' => '5',
            'norma_analis_female_max' => '15',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '7',
            'name_analis' => 'sugar',
            'norma_analis_male_min' => '3.3',
            'norma_analis_male_max' => '5,5',
            'norma_analis_female_min' => '3.3',
            'norma_analis_female_max' => '5.5',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '8',
            'name_analis' => 'Ph',
            'norma_analis_male_min' => '5',
            'norma_analis_male_max' => '6',
            'norma_analis_female_min' => '5',
            'norma_analis_female_max' => '6',
        ]);

        DB::table('Analis')->insert([
            'id_analis' => '9',
            'name_analis' => 'Ph',
            'norma_analis_male_min' => '5',
            'norma_analis_male_max' => '6',
            'norma_analis_female_min' => '5',
            'norma_analis_female_max' => '6',
        ]);
    }
}
