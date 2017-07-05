<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(VitaminsSeeder::class);
        $this->call(TypeTrainsSeeder::class);
        $this->call(ExercisesSeeder::class);
        $this->call(AnalisSeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(SleepSeeder::class);

    }
}
