<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 10:12 PM
 */

namespace Kiyon\Laravel\Foundation\Model\GlobalScopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Kiyon\Laravel\Member\Model\Member;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Support\Constant;

class UserTypeScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $role = null;

        if ($model instanceof Member) {
            $role = Constant::ROLE_MEMBER;
        }
        if ($model instanceof Staff) {
            $role = Constant::ROLE_STAFF;
        }

        if ($role) {
            $builder->whereHas('roles', function (Builder $query) use ($role) {
                return $query->where('key', $role);
            });
        }
    }
}