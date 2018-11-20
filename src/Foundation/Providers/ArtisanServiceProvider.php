<?php

namespace Kiyon\Laravel\Foundation\Providers;

use Kiyon\Laravel\Console\ModControllerMakeCommand;
use Kiyon\Laravel\Console\ModModelMakeCommand;
use Kiyon\Laravel\Support\ServiceProviders\ServiceProvider;

class ArtisanServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        'ModModelMake'      => 'command.mod.model.make',
        'ModControllerMake' => 'command.mod.controller.make',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands(array_merge(
            $this->commands, $this->devCommands
        ));
    }

    /**
     * Register the given commands.
     *
     * @param  array $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModModelMakeCommand()
    {
        $this->app->singleton('command.mod.model.make', function ($app) {
            return new ModModelMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModControllerMakeCommand()
    {
        $this->app->singleton('command.mod.controller.make', function ($app) {
            return new ModControllerMakeCommand($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(array_values($this->commands), array_values($this->devCommands));
    }
}
