<?php

namespace Kiyon\Laravel\Authentication;

use Kiyon\Laravel\Authentication\Contracts\UserRepositoryContract;
use Kiyon\Laravel\Authentication\Repository\UserRepository;
use Tymon\JWTAuth\Providers\LaravelServiceProvider as JWTServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class AuthenticationServiceProvider extends JWTServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->registerEloquentFactoriesFrom(__DIR__ . '/database/factories');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
    }

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
