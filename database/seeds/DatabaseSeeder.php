<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application'js database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(PermissionSeeder::class);
//        $this->call(UserSeeder::class);
//        $this->call(PostSeeder::class);
        $this->call(LikesSeeder::class);
//        $this->call(CommentsSeeder::class);
//        $this->call(CommentLikesSeeder::class);
    }
}
