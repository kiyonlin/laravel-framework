<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 11:36 AM
 */

namespace Kiyon\Laravel\Foundation\Providers;

use Spatie\QueryBuilder\QueryBuilderServiceProvider as SpatieQueryBuilderServiceProvider;

class QueryBuilderServiceProvider extends SpatieQueryBuilderServiceProvider
{

    public function boot()
    {
        parent::boot();
    }
}