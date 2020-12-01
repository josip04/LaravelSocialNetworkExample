<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use App\Posts;
use App\User;

$factory->define(Posts::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'body' => $faker->sentence,
        'image' => $faker->paragraph,
        'user_id' => User::all()->random()->id
    ];
});
