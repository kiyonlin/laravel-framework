<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:30 PM
 */

namespace Tests\Feature\Authorization;


use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class PermissionGrantTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不可以给权限分配用户()
    {
        $this->withExceptionHandling();

        $permission = create(Permission::class);

        $this->putJson(route('system.permission.grant-user', ['permission' => $permission->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给权限分配用户()
    {
        $this->signInSystemAdmin();

        /** @var Permission $permission */
        $permission = create(Permission::class);

        $user = create(User::class);

        $permissionUserIds = $permission->users->pluck('id')->toArray();
        $this->assertFalse(in_array($user->id, $permissionUserIds));

        $this->putJson(route('system.permission.grant-user', ['permission' => $permission->id]), ['userIds' => $user->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $permissionUserIds = $permission->fresh()->users->pluck('id')->toArray();

        $this->assertTrue(in_array($user->id, $permissionUserIds));
    }

    /** @test */
    public function 未授权用户不可以给权限分配角色()
    {
        $this->withExceptionHandling();

        $permission = create(Permission::class);

        $this->putJson(route('system.permission.grant-role', ['permission' => $permission->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给权限分配角色()
    {
        $this->signInSystemAdmin();

        /** @var Permission $permission */
        $permission = create(Permission::class);

        $role = create(Role::class);

        $permissionRoleIds = $permission->roles->pluck('id')->toArray();
        $this->assertFalse(in_array($permission->id, $permissionRoleIds));

        $this->putJson(route('system.permission.grant-role', ['permission' => $permission->id]), ['roleIds' => $role->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $permissionRoleIds = $permission->fresh()->roles->pluck('id')->toArray();

        $this->assertTrue(in_array($role->id, $permissionRoleIds));
    }

    /** @test */
    public function 未授权用户不可以给权限分配组织()
    {
        $this->withExceptionHandling();

        $permission = create(Permission::class);

        $this->putJson(route('system.permission.grant-organization', ['permission' => $permission->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给权限分配组织()
    {
        $this->signInSystemAdmin();

        /** @var Permission $permission */
        $permission = create(Permission::class);

        $organization = create(Organization::class);

        $permissionOrganizationIds = $permission->organizations->pluck('id')->toArray();
        $this->assertFalse(in_array($permission->id, $permissionOrganizationIds));

        $this->putJson(route('system.permission.grant-organization', ['permission' => $permission->id]), ['organizationIds' => $organization->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $permissionOrganizationIds = $permission->fresh()->organizations->pluck('id')->toArray();

        $this->assertTrue(in_array($organization->id, $permissionOrganizationIds));
    }
}