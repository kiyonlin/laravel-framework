<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:30 PM
 */

namespace Tests\Feature\Authorization;


use Illuminate\Foundation\Testing\WithFaker;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Support\Constant;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class RoleGrantTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不可以给角色分配用户()
    {
        $this->withExceptionHandling();

        $this->putJson(route('system.role.grant-user', ['role' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给角色分配用户()
    {
        $this->signInSystemAdmin();

        /** @var Role $role */
        $role = create(Role::class);

        $user = create(User::class);

        $roleUserIds = $role->users->pluck('id')->toArray();
        $this->assertFalse(in_array($user->id, $roleUserIds));

        $this->putJson(route('system.role.grant-user', ['role' => $role->id]), ['userIds' => $user->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $roleUserIds = $role->fresh()->users->pluck('id')->toArray();

        $this->assertTrue(in_array($user->id, $roleUserIds));
    }

    /** @test */
    public function 未授权用户不可以给角色分配权限()
    {
        $this->withExceptionHandling();

        $this->putJson(route('system.role.grant-permission', ['role' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给角色分配权限()
    {
        $this->signInSystemAdmin();

        /** @var Role $role */
        $role = create(Role::class);

        $permission = create(Permission::class);

        $rolePermissionIds = $role->permissions->pluck('id')->toArray();
        $this->assertFalse(in_array($permission->id, $rolePermissionIds));

        $this->putJson(route('system.role.grant-permission', ['role' => $role->id]), ['permissionIds' => $permission->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $rolePermissionIds = $role->fresh()->permissions->pluck('id')->toArray();

        $this->assertTrue(in_array($permission->id, $rolePermissionIds));
    }
}