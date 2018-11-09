<?php

namespace Tests;

use Kiyon\Laravel\Authentication\AuthenticationServiceProvider;
use Kiyon\Laravel\Authorization\AuthorizationServiceProvider;
use Kiyon\Laravel\Menu\MenuServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            AuthenticationServiceProvider::class,
            AuthorizationServiceProvider::class,
            MenuServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('app.timezone', 'RPC');
        $app['config']->set('app.locale', 'zh_CN');
        $app['config']->set('app.faker_locale', 'zh_CN');
    }

    /**
     * Get application timezone.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return string|null
     */
    protected function getApplicationTimezone($app)
    {
        return 'Asia/shanghai';
    }
}
