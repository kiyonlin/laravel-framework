<?php

use Faker\Generator as Faker;
use Kiyon\Laravel\Authentication\Model\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username'       => $faker->unique()->name,
        'display_name'   => $faker->name,
        'mobile'         => $faker->unique()->phoneNumber,
        'email'          => $faker->unique()->email,
        'password'       => '111111',
        'locked'         => false,
        'remember_token' => str_random(10),
    ];
});
