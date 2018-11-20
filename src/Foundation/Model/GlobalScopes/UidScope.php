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
use Kiyon\Laravel\Support\Constant;

class UidScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if ($this->modelHasUid($model) && $this->isMember($user = auth()->user())) {
            $builder->where('uid', $user->id);
        }
    }

    private function modelHasUid(Model $model)
    {
        return in_array('uid', $model->getFillable());
    }

    private function isMember($user)
    {
        return $user ?
            $user->whereHas('roles', function (Builder $query) {
                return $query->where('key', Constant::ROLE_MEMBER);
            })->exists()
            : false;
    }
}