<?php

use Illuminate\Database\Seeder;

class AddRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $users = \App\Models\User::all();
        foreach ($users as $user)
        {
            $user->assignRole(['user']);
        }

    }
}
