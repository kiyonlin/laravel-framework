<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Authorization;


use Kiyon\Laravel\Authorization\Model\Organization;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class OrganizationTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不能查看组织列表()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.organization.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看组织列表()
    {
        $this->signInSystemAdmin();

        create(Organization::class, 5);

        $resp = $this->getJson(route('system.organization.index'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount(5, $resp);
    }

    /** @test */
    public function 未授权用户不能添加组织()
    {
        $this->withExceptionHandling();

        $organization = raw(Organization::class);

        $this->postJson(route('system.organization.store'), $organization)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以添加组织()
    {
        $this->signInSystemAdmin();

        $organization = raw(Organization::class);

        $resp = $this->postJson(route('system.organization.store'), $organization)
            ->assertStatus(Response::HTTP_CREATED)
            ->json();

        $this->assertEquals($organization, array_only($resp, array_keys($organization)));
    }

    /** @test */
    public function 未授权用户不能删除组织()
    {
        $this->withExceptionHandling();

        $organization = create(Organization::class);

        $this->deleteJson(route('system.organization.destroy', ['organization' => $organization->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以删除组织()
    {
        $this->signInSystemAdmin();

        $organization = create(Organization::class);

        $this->deleteJson(route('system.organization.destroy', ['organization' => $organization->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing($organization->getTable(), ['id' => $organization->id]);
    }

    /** @test */
    public function 未授权用户不能更新组织()
    {
        $this->withExceptionHandling();

        $organization = create(Organization::class);

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.organization.update', ['organization' => $organization->id]), $update)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以更新组织()
    {
        $this->signInSystemAdmin();

        $organization = create(Organization::class);

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.organization.update', ['organization' => $organization->id]), $update)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas($organization->getTable(), array_merge(['id' => $organization->id], $update));
    }

    /** @test */
    public function 授权用户可以批量删除组织()
    {
        $this->signInSystemAdmin();

        $organizations = create(Organization::class, 5);

        $this->deleteJson(route('system.organization.destroy', ['organization' => $organizations[0]->id]),
            ['ids' => $organizations->pluck('id')->toArray()])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $organizations->each(function ($organization) {
            $this->assertDatabaseMissing($organization->getTable(), ['id' => $organization->id]);
        });
    }
}