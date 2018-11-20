<?php

use Faker\Generator as Faker;

$factory->define(\Kiyon\Laravel\Member\Model\Member::class, function (Faker $faker) {
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