<?php

namespace Kiyon\Laravel\Staff;

use Kiyon\Laravel\Staff\Contracts\StaffRepositoryContract;
use Kiyon\Laravel\Staff\Repository\StaffRepository;
use Kiyon\Laravel\Support\ServiceProviders\ServiceProvider;

class StaffServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEloquentFactoriesFrom(__DIR__ . '/database/factories');

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        $this->app->bind(StaffRepositoryContract::class, StaffRepository::class);
    }
}
