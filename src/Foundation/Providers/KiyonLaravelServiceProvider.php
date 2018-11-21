<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 11:36 AM
 */

namespace Kiyon\Laravel\Foundation\Providers;

use Kiyon\Laravel\Authentication\AuthenticationServiceProvider;
use Kiyon\Laravel\Authorization\AuthorizationServiceProvider;
use Kiyon\Laravel\Member\MemberServiceProvider;
use Kiyon\Laravel\Menu\MenuServiceProvider;
use Kiyon\Laravel\Staff\StaffServiceProvider;
use Kiyon\Laravel\Support\ServiceProviders\ServiceProvider;

class KiyonLaravelServiceProvider extends ServiceProvider
{

    protected $providers = [
        AuthenticationServiceProvider::class,
        AuthorizationServiceProvider::class,
        MenuServiceProvider::class,
        QueryBuilderServiceProvider::class,
        MemberServiceProvider::class,
        StaffServiceProvider::class,
        ArtisanServiceProvider::class
    ];

    public function register()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '../../../phpunit.xml.dist' => base_path('phpunit.xml.dist'),
        ]);
    }
}