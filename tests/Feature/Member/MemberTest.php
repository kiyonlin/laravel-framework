<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Member;


use Kiyon\Laravel\Member\Model\Member;
use Kiyon\Laravel\Support\Constant;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class MemberTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不能查看会员列表()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.member.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看会员列表()
    {
        $this->signInSystemAdmin();

        createMember(5);

        $resp = $this->getJson(route('system.member.index'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount(5, $resp);
    }

    /** @test */
    public function 未授权用户不能添加会员()
    {
        $this->withExceptionHandling();

        $member = raw(Member::class);

        $this->postJson(route('system.member.store'), $member)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以添加会员()
    {
        $this->signInSystemAdmin();

        $member = raw(Member::class);

        $resp = $this->postJson(route('system.member.store'), $member)
            ->assertStatus(Response::HTTP_CREATED)
            ->json();

        $this->assertEquals($member['email'], array_get($resp, 'email'));
        $this->assertEquals(Constant::ROLE_MEMBER, array_get($resp, 'roles.0.key'));
    }

    /** @test */
    public function 未授权用户不能查看会员()
    {
        $this->withExceptionHandling();

        $member = createMember();

        $this->getJson(route('system.member.show', ['member' => $member->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看会员()
    {
        $this->signInSystemAdmin();

        $member = createMember();

        $resp = $this->getJson(route('system.member.show', ['member' => $member->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertEquals($member['email'], array_get($resp, 'email'));
        $this->assertEquals(Constant::ROLE_MEMBER, array_get($resp, 'roles.0.key'));
    }

    /** @test */
    public function 未授权用户不能删除会员()
    {
        $this->withExceptionHandling();

        $member = createMember();

        $this->deleteJson(route('system.member.destroy', ['member' => $member->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以删除会员()
    {
        $this->signInSystemAdmin();

        $member = createMember();

        $this->deleteJson(route('system.member.destroy', ['member' => $member->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing($member->getTable(), ['id' => $member->id]);
    }

    /** @test */
    public function 未授权用户不能更新会员()
    {
        $this->withExceptionHandling();

        $member = createMember();

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.member.update', ['member' => $member->id]), $update)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以更新会员()
    {
        $this->signInSystemAdmin();

        $member = createMember();

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.member.update', ['member' => $member->id]), $update)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas($member->getTable(), array_merge(['id' => $member->id], $update));
    }

    /** @test */
    public function 授权用户可以批量删除会员()
    {
        $this->signInSystemAdmin();

        $members = createMember(5);

        $this->deleteJson(route('system.member.destroy', ['member' => $members[0]->id]),
            ['ids' => $members->pluck('id')->toArray()])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $members->each(function ($member) {
            $this->assertDatabaseMissing($member->getTable(), ['id' => $member->id]);
        });
    }
}