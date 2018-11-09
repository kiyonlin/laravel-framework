<?php

use Faker\Generator as Faker;
use Kiyon\Laravel\Menu\Menu;
use Kiyon\Laravel\Support\Constant;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'parent_id' => 0,

        'text'  => $faker->word,
        'i18n'  => $faker->word,
        'type'  => Constant::MENU_SIDE_NAV,
        'group' => false,

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
