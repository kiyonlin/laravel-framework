<?php

namespace Kiyon\Laravel\Member\Model;

use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Foundation\Model\GlobalScopes\UserTypeScope;

class Member extends User
{
    /**
     * 模型的「启动」方法
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserTypeScope());
    }
}