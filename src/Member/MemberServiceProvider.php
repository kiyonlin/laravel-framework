<?php

namespace Kiyon\Laravel\Member;

use Kiyon\Laravel\Member\Contracts\MemberRepositoryContract;
use Kiyon\Laravel\Member\Repository\MemberRepository;
use Kiyon\Laravel\Support\ServiceProviders\ServiceProvider;

class MemberServiceProvider extends ServiceProvider
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

        $this->app->bind(MemberRepositoryContract::class, MemberRepository::class);
    }
}
