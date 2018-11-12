<?php

namespace Kiyon\Laravel\Authorization;

use Kiyon\Laravel\Support\ServiceProviders\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'authorization');

        $this->registerEloquentFactoriesFrom(__DIR__ . '/database/factories');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('authorization.php'),
        ], 'config');
    }
}
