<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Kiyon\Laravel\Authentication\Service\UserService;

if (! function_exists('can')) {
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

if (! function_exists('deny')) {
    /**
     * 用户权限辅助方法
     *
     * @param Authenticatable $user
     * @param string|array $ability
     * @return bool
     */
    function deny(Authenticatable $user, $ability)
    {
        return ! app(UserService::class)->can($user, $ability);
    }
}