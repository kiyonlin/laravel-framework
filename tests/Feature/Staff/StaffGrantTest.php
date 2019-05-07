<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Staff;


use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Staff\Model\Staff;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class StaffGrantTest extends AuthTestCase
{
    /** @test */
    public function 未授权用户不可以给员工分配角色()
    {
        $this->withExceptionHandling();

        $this->putJson(route('system.staff.grant-role', ['staff' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给员工分配角色()
    {
        $this->signInSystemAdmin();

        /** @var Staff $staff */
        $staff = createStaff();

        $role = create(Role::class);

        $staffRoleIds = $staff->roles->pluck('id')->toArray();
        $this->assertFalse(in_array($role->id, $staffRoleIds));

        $resp = $this->putJson(route('system.staff.grant-role', ['staff' => $staff->id]), ['roleIds' => $role->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $staffRoleIds = $staff->fresh()->roles->pluck('id')->toArray();
        $respRoleIds = collect(array_get($resp, 'roles'))->pluck('id')->toArray();

        $this->assertEquals($staffRoleIds, $respRoleIds);
        $this->assertTrue(in_array($role->id, $staffRoleIds));
    }

    /** @test */
    public function 未授权用户不可以给员工分配权限()
    {
        $this->withExceptionHandling();

        $this->putJson(route('system.staff.grant-permission', ['staff' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给员工分配权限()
    {
        $this->signInSystemAdmin();

        /** @var Staff $staff */
        $staff = createStaff();

        $permission = create(Permission::class);

        $staffPermissionIds = $staff->permissions->pluck('id')->toArray();
        $this->assertFalse(in_array($permission->id, $staffPermissionIds));

        $resp = $this->putJson(route('system.staff.grant-permission', ['staff' => $staff->id]), ['permissionIds' => $permission->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $staffPermissionIds = $staff->fresh()->permissions->pluck('id')->toArray();
        $respPermissionIds = collect(array_get($resp, 'permissions'))->pluck('id')->toArray();

        $this->assertEquals($staffPermissionIds, $respPermissionIds);
        $this->assertTrue(in_array($permission->id, $staffPermissionIds));
    }

    /** @test */
    public function 未授权用户不可以给员工分配组织()
    {
        $this->withExceptionHandling();

        $this->putJson(route('system.staff.grant-organization', ['staff' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给员工分配组织()
    {
        $this->signInSystemAdmin();

        /** @var Staff $staff */
        $staff = createStaff();

        $organization = create(Organization::class);

        $staffOrganizationIds = $staff->organizations->pluck('id')->toArray();
        $this->assertFalse(in_array($organization->id, $staffOrganizationIds));

        $resp = $this->putJson(route('system.staff.grant-organization', ['staff' => $staff->id]), ['organizationIds' => $organization->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $staffOrganizationIds = $staff->fresh()->organizations->pluck('id')->toArray();
        $respOrganizationIds = collect(array_get($resp, 'organizations'))->pluck('id')->toArray();

        $this->assertEquals($staffOrganizationIds, $respOrganizationIds);
        $this->assertTrue(in_array($organization->id, $staffOrganizationIds));
    }
}