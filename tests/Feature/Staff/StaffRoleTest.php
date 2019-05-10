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

class StaffRoleTest extends AuthTestCase
{
    /** @test */
    public function 未授权用户不可以查看员工角色分配情况()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.staff.show-role', ['staff' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看员工角色分配情况()
    {
        $this->signInSystemAdmin();

        /** @var Staff $staff */
        $staff = createStaff();

        $resp = $this->getJson(route('system.staff.show-role', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        // 拥有员工角色
        $this->assertCount(1, array_get($resp, 'owns'));
    }

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
    public function 未授权用户不可以取消员工角色()
    {
        $this->withExceptionHandling();

        $this->deleteJson(route('system.staff.delete-role', ['staff' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以取消员工角色()
    {
        $this->signInSystemAdmin();

        /** @var Staff $staff */
        $staff = createStaff();

        $this->deleteJson(route('system.staff.delete-role', ['staff' => $staff->id]), ['roleIds' => $staff->roles[0]->id])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertCount(0, $staff->fresh(['roles'])->roles);
    }
}