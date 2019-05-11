<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:30 PM
 */

namespace Tests\Feature\Authorization;


use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class OrganizationPermissionTest extends AuthTestCase
{
    /** @test */
    public function 未授权用户不可以显示组织分配权限情况()
    {
        $this->withExceptionHandling();

        $organization = create(Organization::class);

        $this->getJson(route('system.organization.show-permission', ['organization' => $organization->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看组织权限分配情况()
    {
        $this->signInSystemAdmin();

        /** @var Organization $organization */
        $organization = create(Organization::class);

        $permission = create(Permission::class);
        $organization->syncPermissions($permission);

        $resp = $this->getJson(route('system.organization.show-permission', ['organization' => $organization->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertEquals([$permission->id], $resp['defaultChecked']);
        $this->assertCount(1, $resp['nodes']);
    }

    /** @test */
    public function 未授权用户不可以给组织分配权限()
    {
        $this->withExceptionHandling();

        $organization = create(Organization::class);

        $this->putJson(route('system.organization.grant-permission', ['organization' => $organization->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给组织分配权限()
    {
        $this->signInSystemAdmin();

        /** @var Organization $organization */
        $organization = create(Organization::class);

        $permission = create(Permission::class);

        $organizationPermissionIds = $organization->permissions->pluck('id')->toArray();
        $this->assertFalse(in_array($permission->id, $organizationPermissionIds));

        $this->putJson(route('system.organization.grant-permission', ['organization' => $organization->id]), ['permissionIds' => $permission->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $organizationPermissionIds = $organization->fresh()->permissions->pluck('id')->toArray();

        $this->assertTrue(in_array($permission->id, $organizationPermissionIds));
    }
}