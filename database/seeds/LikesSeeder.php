<?php

use Illuminate\Database\Seeder;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::query()->cursor();

        foreach ($users as $user)
        {
            for($i = 0; $i < rand(10,15); $i++)
            {
                $random = rand(0,180);
                try
                {
                    $user->likes()->attach($random,['id'=> $user->id . $random]);
                }
                catch (Exception $er)
                {
                    continue;
                }
            }
        }

    }
}
