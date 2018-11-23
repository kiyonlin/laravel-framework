<?php

namespace Kiyon\Laravel\Menu;

use Kiyon\Laravel\Menu\Contracts\MenuRepositoryContract;
use Kiyon\Laravel\Menu\Repository\MenuRepository;
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

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        $this->app->bind(MenuRepositoryContract::class, MenuRepository::class);
    }
}
