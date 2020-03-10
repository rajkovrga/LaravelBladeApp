<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'desc' => $faker->text(160),
        'user_id' => \App\Models\User::all()->random()->id
    ];
});
