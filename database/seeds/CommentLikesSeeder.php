<?php

use Illuminate\Database\Seeder;

class CommentLikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::query()->cursor();
        $comments = \Illuminate\Support\Facades\DB::table('comments')->count();
        foreach ($users as $user)
        {
            try {
                for($i = 0; $i < rand(2,10);$i++)
                {
                    $random = rand(1,$comments);

                    $user->commentLikes()->attach($random,['id' => $user->id . $random]);

                }
            }
            catch (Exception $er)
            {
                continue;
            }
        }

    }
}
