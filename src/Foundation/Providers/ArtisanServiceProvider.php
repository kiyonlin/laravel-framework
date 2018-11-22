<?php

namespace Kiyon\Laravel\Foundation\Providers;

use Kiyon\Laravel\Console\ModMake\ModControllerMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModFactoryMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModFeatureTestMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModMigrationMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModModelMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModModuleMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModRepositoryContractMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModRepositoryMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModRequestMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModRoutesMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModServiceMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModServiceProviderMakeCommand;
use Kiyon\Laravel\Console\ModMake\ModUnitTestMakeCommand;
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
        'ModModuleMake'             => 'command.mod.module.make',
        'ModModelMake'              => 'command.mod.model.make',
        'ModControllerMake'         => 'command.mod.controller.make',
        'ModRepositoryMake'         => 'command.mod.repository.make',
        'ModRepositoryContractMake' => 'command.mod.repository.contract.make',
        'ModServiceMake'            => 'command.mod.service.make',
        'ModServiceProviderMake'    => 'command.mod.service-provider.make',
        'ModRoutesMake'             => 'command.mod.routes.make',
        'ModMigrationMake'          => 'command.mod.migration.make',
        'ModFactoryMake'            => 'command.mod.factory.make',
        'ModRequestMake'            => 'command.mod.request.make',
        'ModUnitTestMake'           => 'command.mod.unit-test.make',
        'ModFeatureTestMake'        => 'command.mod.feature-test.make',
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
    protected function registerModModuleMakeCommand()
    {
        $this->app->singleton('command.mod.module.make', function () {
            return new ModModuleMakeCommand();
        });
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
     * Register the command.
     *
     * @return void
     */
    protected function registerModRepositoryMakeCommand()
    {
        $this->app->singleton('command.mod.repository.make', function ($app) {
            return new ModRepositoryMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModRepositoryContractMakeCommand()
    {
        $this->app->singleton('command.mod.repository.contract.make', function ($app) {
            return new ModRepositoryContractMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModServiceMakeCommand()
    {
        $this->app->singleton('command.mod.service.make', function ($app) {
            return new ModServiceMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModServiceProviderMakeCommand()
    {
        $this->app->singleton('command.mod.service-provider.make', function ($app) {
            return new ModServiceProviderMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModRoutesMakeCommand()
    {
        $this->app->singleton('command.mod.routes.make', function ($app) {
            return new ModRoutesMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModMigrationMakeCommand()
    {
        $this->app->singleton('command.mod.migration.make', function ($app) {
            return new ModMigrationMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModFactoryMakeCommand()
    {
        $this->app->singleton('command.mod.factory.make', function ($app) {
            return new ModFactoryMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModRequestMakeCommand()
    {
        $this->app->singleton('command.mod.request.make', function ($app) {
            return new ModRequestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModUnitTestMakeCommand()
    {
        $this->app->singleton('command.mod.unit-test.make', function ($app) {
            return new ModUnitTestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModFeatureTestMakeCommand()
    {
        $this->app->singleton('command.mod.feature-test.make', function ($app) {
            return new ModFeatureTestMakeCommand($app['files']);
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
