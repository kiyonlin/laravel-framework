<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:30 PM
 */

namespace Tests\Feature\Authorization;


use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class RolePermissionTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不可以查看角色权限分配情况()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.role.show-permission', ['role' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看角色权限分配情况()
    {
        $this->signInSystemAdmin();

        /** @var Role $role */
        $role = create(Role::class);

        $permission = create(Permission::class);
        $role->syncPermissions($permission);

        $resp = $this->getJson(route('system.role.show-permission', ['role' => $role->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertEquals([$permission->id], $resp['defaultChecked']);
        $this->assertCount(1, $resp['nodes']);
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

        $oldPermission = create(Permission::class);
        $role->permissions()->attach($oldPermission);

        $permission = create(Permission::class);

        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        $this->assertTrue(in_array($oldPermission->id, $rolePermissionIds));
        $this->assertFalse(in_array($permission->id, $rolePermissionIds));

        $this->putJson(route('system.role.grant-permission', ['role' => $role->id]), ['permissionIds' => $permission->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $rolePermissionIds = $role->fresh()->permissions->pluck('id')->toArray();

        $this->assertFalse(in_array($oldPermission->id, $rolePermissionIds));
        $this->assertTrue(in_array($permission->id, $rolePermissionIds));
    }

}