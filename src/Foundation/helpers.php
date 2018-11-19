<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authentication\Service\UserService;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Support\Constant;

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

if (! function_exists('getSystemAdmin')) {
    /**
     * @return User
     */
    function getSystemAdmin()
    {
        $systemAdmin = create(User::class);

        $systemAdmin->syncRoles(Role::where('key', Constant::ROLE_SYSTEM_ADMIN)->first());

        return $systemAdmin;
    }
}

if (! function_exists('getMember')) {
    /**
     * @return User
     */
    function getMember()
    {
        $member = create(User::class);

        $member->syncRoles(Role::where('key', Constant::ROLE_MEMBER)->first());

        return $member;
    }
}

if (! function_exists('getStaff')) {
    /**
     * @return User
     */
    function getStaff()
    {
        $staff = create(User::class);

        $staff->syncRoles(Role::where('key', Constant::ROLE_STAFF)->first());

        return $staff;
    }
}