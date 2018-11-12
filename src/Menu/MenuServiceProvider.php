<?php

namespace Kiyon\Laravel\Menu;

use Kiyon\Laravel\Support\ServiceProviders\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEloquentFactoriesFrom(__DIR__ . '/database/factories');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
