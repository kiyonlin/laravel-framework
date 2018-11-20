<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 2:55 PM
 */

namespace Kiyon\Laravel\Staff\Model;

use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Foundation\Model\GlobalScopes\UserTypeScope;

class Staff extends User
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