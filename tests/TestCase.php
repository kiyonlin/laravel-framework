<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Facade;
use Kiyon\Laravel\Authentication\AuthenticationServiceProvider;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\AuthorizationServiceProvider;
use Kiyon\Laravel\Member\MemberServiceProvider;
use Kiyon\Laravel\Foundation\Http\Kernel as HttpKernel;
use Kiyon\Laravel\Foundation\QueryBuilderServiceProvider;
use Kiyon\Laravel\Menu\MenuServiceProvider;
use Kiyon\Laravel\Staff\StaffServiceProvider;
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
            QueryBuilderServiceProvider::class,
            MemberServiceProvider::class,
            StaffServiceProvider::class
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

        $app['config']->set('query-builder.parameters.include', 'load');
        $app['config']->set('query-builder.parameters.filter', 'search');
        $app['config']->set('query-builder.parameters.fields', 'select');
        $app['config']->set('query-builder.parameters.sort', 'sort');
        $app['config']->set('query-builder.parameters.append', 'append');
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
     * @return $this
     */
    protected function signInSystemAdmin()
    {
        return $this->signIn(createSystemAdmin());
    }
}
