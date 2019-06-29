<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Staff;


use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Staff\Model\Staff;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class StaffOrganizationTest extends AuthTestCase
{
    /** @test */
    public function 未授权用户不可以查看员工组织分配情况()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.staff.show-organization', ['staff' => 1]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看员工组织分配情况()
    {
        $this->signInSystemAdmin();

        /** @var Staff $staff */
        $staff = createStaff();

        $resp = $this->getJson(route('system.staff.show-organization', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount(0, $resp['defaultChecked']);
        $this->assertCount(0, $resp['nodes']);
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