<?php

use Illuminate\Database\Seeder;

class ExercisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'squat',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'deadlift',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'leg press',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'lunge',
            'difficulty' => '0',
            'category' => '0',
        ]);
        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'box jump',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'ball leg curl',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'leg swing',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '1',
            'name' => 'hamstring',
            'difficulty' => '0',
            'category' => '0',
        ]);




        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'Bent-Over Barbell Deadlift',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'Pull-Up',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'Standing T-Bar Row',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'Single-Arm Dumbbell Row',
            'difficulty' => '0',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'bodyweight mid row',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'cat stretch',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'crossover reverse lunge',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '2',
            'name' => 'inverted row',
            'difficulty' => '0',
            'category' => '0',
        ]);



        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'Bench press',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'Dumbbell Flyes',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'Incline Dumbbell Press',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'Dumbbell Pullover',
            'difficulty' => '0',
            'category' => '0',
        ]);


        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'bodyweight flyes',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'elbows back',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'bag thrust',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '3',
            'name' => 'push-up',
            'difficulty' => '0',
            'category' => '0',
        ]);



        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'Bent-Knee Hip Raise',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'Barbell Ab Rollout - On Knees ',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'Barbell Side Bend',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'Bottoms Up',
            'difficulty' => '0',
            'category' => '0',
        ]);


        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'ab roller',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'air bike ',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'bent press',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '4',
            'name' => 'AB crunch machine',
            'difficulty' => '0',
            'category' => '0',
        ]);



        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'Barbell Curl',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'Dips',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'Dumbbell One-Arm Triceps Extension',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'Dumbbell Floor Press',
            'difficulty' => '0',
            'category' => '0',
        ]);


        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'plate pinch',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'wrist curl',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'drag curl',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '5',
            'name' => 'preacher curl',
            'difficulty' => '0',
            'category' => '0',
        ]);



        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'Neck Bridge Prone',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'Side Neck Stretch',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'Lying Face Down Plate Neck Resistance',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'Chin To Chest Stretch',
            'difficulty' => '0',
            'category' => '0',
        ]);



        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'Neck smr',
            'difficulty' => '1',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'isometric neck sides',
            'difficulty' => '0',
            'category' => '1',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'Lying Face Up Plate Neck Resistance',
            'difficulty' => '1',
            'category' => '0',
        ]);

        DB::table('exercises')->insert([
            'id_type' => '6',
            'name' => 'Seated head harness neck resistance',
            'difficulty' => '0',
            'category' => '0',
        ]);
    }
}
