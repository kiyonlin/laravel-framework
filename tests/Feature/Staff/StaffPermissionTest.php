<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Staff;


use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Staff\Model\Staff;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class StaffPermissionTest extends AuthTestCase
{
    /** @test */
    public function 未授权用户不可以查看员工权限分配情况()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.staff.show-permission', ['staff' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看员工权限分配情况()
    {
        $this->signInSystemAdmin();

        /** @var Staff $staff */
        $staff = createStaff();

        $resp = $this->getJson(route('system.staff.show-permission', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        // 拥有员工权限
        $this->assertCount(0, $resp);
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

}