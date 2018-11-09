<?php

use Faker\Generator as Faker;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'key'          => str_random(),
        'display_name' => $faker->name,
        'description'  => $faker->sentence,
    ];
});

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'key'          => str_random(),
        'display_name' => $faker->name,
        'description'  => $faker->sentence,
    ];
});

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'parent_id'    => 0,
        'key'          => str_random(),
        'display_name' => $faker->name,
        'description'  => $faker->sentence,
        'level'        => 1
    ];
});
