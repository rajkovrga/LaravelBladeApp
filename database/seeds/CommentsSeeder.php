<?php

use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::query()->cursor();
        $faker = \Faker\Factory::create();
        foreach ($users as $user)
        {
            for($i = 0; $i < rand(5,10);$i++)
            {
                $random = rand(1,160);
                    $user->comments()->attach($random,[
                        'desc' => $faker->text(250)]);
            }
        }

    }
}
