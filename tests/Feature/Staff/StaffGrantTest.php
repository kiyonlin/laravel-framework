<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Staff;


use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Support\Constant;
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
}