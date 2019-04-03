<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Kiyon\Laravel\Authentication\Service\UserService;

if (!function_exists('can')) {
    /**
     * 用户权限辅助方法
     *
     * @param Authenticatable $user
     * @param string|array $ability
     * @return bool
     */
    function can(Authenticatable $user, $ability)
    {
        return app(UserService::class)->can($user, $ability);
    }
}

if (!function_exists('deny')) {
    /**
     * 用户权限辅助方法
     *
     * @param Authenticatable $user
     * @param string|array $ability
     * @return bool
     */
    function deny(Authenticatable $user, $ability)
    {
        return !app(UserService::class)->can($user, $ability);
    }
}

if (!function_exists('formatMenu')) {
    /**
     * 格式化菜单数组信息
     *
     * @return array
     */
    function formatMenu(Array $menu, array $except = [])
    {
        if (empty($except)) {
            return array_except($menu, [
                'id', 'parent_id', 'parent_menu', 'created_at', 'updated_at', 'type'
            ]);
        } else {
            return array_except($menu, $except);
        }
    }
}