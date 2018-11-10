<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 4:54 PM
 */

namespace Tests\Feature\Authorization;


use Illuminate\Support\Facades\Route;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Support\Constant;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class AbilityMiddlewareTest extends AuthTestCase
{

    /** @test */
    public function 权限中间件通过()
    {
        /** @var User $user */
        $user = auth()->user();
        $permission = create(Permission::class, ['key' => 'user']);
        $user->syncPermissions($permission);

        Route::middleware('ability:user')->get('foo', function () {
            return 'hit';
        });

        $resp = $this->get('foo')->content();

        $this->assertEquals('hit', $resp);
    }

    /** @test */
    public function 权限中间件不通过()
    {
        $this->withExceptionHandling();

        Route::middleware('ability:user')->get('foo', function () {
            return 'hit';
        });

        $this->get('foo')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 系统管理员通过任意权限中间件()
    {
        /** @var User $user */
        $user = auth()->user();
        $role = create(Role::class, ['key' => Constant::ROLE_SYSTEM_ADMIN]);
        $user->syncRoles($role);

        Route::middleware('ability:anything')->get('foo', function () {
            return 'hit';
        });

        $resp = $this->get('foo')->content();

        $this->assertEquals('hit', $resp);
    }
}