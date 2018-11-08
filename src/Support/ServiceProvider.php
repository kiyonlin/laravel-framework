<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 5:02 PM
 */

namespace Kiyon\Laravel\Support;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

abstract class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Register factories.
     *
     * @param  string $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}