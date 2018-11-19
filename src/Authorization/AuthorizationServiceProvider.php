<?php

namespace Kiyon\Laravel\Authorization;

use Kiyon\Laravel\Authorization\Contracts\OrganizationRepositoryContract;
use Kiyon\Laravel\Authorization\Contracts\PermissionRepositoryContract;
use Kiyon\Laravel\Authorization\Contracts\RoleRepositoryContract;
use Kiyon\Laravel\Authorization\Repository\OrganizationRepository;
use Kiyon\Laravel\Authorization\Repository\PermissionRepository;
use Kiyon\Laravel\Authorization\Repository\RoleRepository;
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

        $this->app->bind(PermissionRepositoryContract::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryContract::class, RoleRepository::class);
        $this->app->bind(OrganizationRepositoryContract::class, OrganizationRepository::class);
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
