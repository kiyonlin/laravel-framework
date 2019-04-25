<?php

use Faker\Generator as Faker;
use Kiyon\Laravel\Menu\Model\Menu;
use Kiyon\Laravel\Support\Constant;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'parent_id' => 0,

        'key'          => $faker->unique()->word,
        'display_name' => $faker->word,
        'type'         => $faker->randomElement(Constant::MENU_TYPE),
        'group'        => false,
        'sort'         => 0,

        'link'          => '-',
        'link_exact'    => false,
        'external_link' => null,
        'target'        => '_self',

        'icon'         => 'anticon anticon-question',
        'badge'        => null,
        'badge_dot'    => false,
        'badge_status' => 'error',

        'hide'               => false,
        'hide_in_breadcrumb' => true,

        'shortcut'      => false,
        'shortcut_root' => false,
    ];
});
