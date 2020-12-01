<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Comments;
use App\Posts;
use App\User;

$factory->define(Comments::class, function (Faker $faker) {
    return [
        'comment' => $faker->sentence,
        'post_id' => Posts::all()->random()->id,
        'user_id' => User::all()->random()->id//User::factory()
    ];
});
