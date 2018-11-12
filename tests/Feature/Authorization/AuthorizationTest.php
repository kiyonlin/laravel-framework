<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 10:49 PM
 */

namespace Tests\Feature\Authorization;


use Closure;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Permission;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class AuthorizationTest extends AuthTestCase
{

    /** @test */
    public function 用户可以获取自己的权限能力()
    {
        /** @var User $user */
        $user = auth()->user();
        $permission = create(Permission::class, ['key' => 'user']);

        $user->syncPermissions($permission);

        $resp = $this->getJson(route('authorization.abilities'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertEquals(['user'], $resp);
    }

    /** @test */
    public function 获取所有带权限中间件的参数()
    {
        $routes = app(Router::class)->getRoutes();
        $routes = collect($routes)->map(function ($route) {
            return collect($route->gatherMiddleware())->filter(function ($middleware) {
                return ! ($middleware instanceof Closure) && strstr($middleware, 'ability');
            })->implode(',');
        })->all();
        $abilities = (array_filter($routes));
        $this->assertTrue(true);
    }
}