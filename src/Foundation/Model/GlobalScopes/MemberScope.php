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

class MemberScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $user = auth()->user();
        dump([$model->getTable(), $model->getFillable(), $user->toArray()]);
        if ($user) {
            $builder->where('uid', $user->uid);
        }
        // $builder->where('uid', $model->uid);
    }
}