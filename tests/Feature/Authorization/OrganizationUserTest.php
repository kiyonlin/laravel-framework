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
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class OrganizationUserTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不可以给组织分配用户()
    {
        $this->withExceptionHandling();

        $organization = create(Organization::class);

        $this->putJson(route('system.organization.grant-user', ['organization' => $organization->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以给组织分配用户()
    {
        $this->signInSystemAdmin();

        /** @var Organization $organization */
        $organization = create(Organization::class);

        $user = create(User::class);

        $organizationUserIds = $organization->users->pluck('id')->toArray();
        $this->assertFalse(in_array($user->id, $organizationUserIds));

        $this->putJson(route('system.organization.grant-user', ['organization' => $organization->id]), ['userIds' => $user->id])
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $organizationUserIds = $organization->fresh()->users->pluck('id')->toArray();

        $this->assertTrue(in_array($user->id, $organizationUserIds));
    }

}