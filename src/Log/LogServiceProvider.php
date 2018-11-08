<?php

namespace Kiyon\Laravel\Log;

use Kiyon\Laravel\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'logging');

        $this->app->singleton('log', function () {
            return new LogManager($this->app);
        });
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
        ]);
    }
}
