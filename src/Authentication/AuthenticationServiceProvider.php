<?php

namespace Kiyon\Laravel\Authorization;

use Kiyon\Laravel\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
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
