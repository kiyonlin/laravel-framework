<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Facade;
use Kiyon\Laravel\Authentication\AuthenticationServiceProvider;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\AuthorizationServiceProvider;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Foundation\Http\Kernel as HttpKernel;
use Kiyon\Laravel\Console\Kernel as ConsoleKernel;
use Kiyon\Laravel\Foundation\QueryBuilderServiceProvider;
use Kiyon\Laravel\Menu\MenuServiceProvider;
use Kiyon\Laravel\Support\Constant;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    use RefreshDatabase;

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();

        Facade::setFacadeApplication($this->app);

        $this->withoutExceptionHandling();

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
            MenuServiceProvider::class,
            QueryBuilderServiceProvider::class
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

        $app['config']->set('auth.defaults.guard', 'api');
        $app['config']->set('auth.guards.api.driver', 'jwt');
        $app['config']->set('auth.providers.users.model', User::class);
    }

    /**
     * Resolve application HTTP Kernel implementation.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', HttpKernel::class);
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

    /**
     * 登录用户
     *
     * @param User|null $user
     * @return $this
     */
    protected function signIn(User $user = null)
    {
        $user = $user ?: create(User::class);

        auth()->login($user);

        return $this;
    }

    /**
     * 登录用户
     *
     * @param User|null $user
     * @return $this
     */
    protected function signInSystemAdmin()
    {
        $user = create(User::class);

        $user->syncRoles(create(Role::class, ['key' => Constant::ROLE_SYSTEM_ADMIN]));

        return $this->signIn($user);
    }
}
