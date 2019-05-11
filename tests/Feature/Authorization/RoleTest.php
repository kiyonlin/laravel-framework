<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:30 PM
 */

namespace Tests\Feature\Authorization;


use Illuminate\Foundation\Testing\WithFaker;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Support\Constant;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class RoleTest extends AuthTestCase
{

    use WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->setUpFaker();
    }

    /** @test */
    public function 未授权用户不能查看角色列表()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.role.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看角色列表()
    {
        $this->signInSystemAdmin();

        create(Role::class, 5);

        $resp = $this->getJson(route('system.role.index'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        // 加上系统初始化角色
        $this->assertCount(5 + count(Constant::INIT_ROLES), $resp);
    }

    /** @test */
    public function 未授权用户不能添加角色()
    {
        $this->withExceptionHandling();

        $role = raw(Role::class);

        $this->postJson(route('system.role.store'), $role)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以添加角色()
    {
        $this->signInSystemAdmin();

        $role = raw(Role::class);

        $resp = $this->postJson(route('system.role.store'), $role)
            ->assertStatus(Response::HTTP_CREATED)
            ->json();

        $this->assertEquals($role, array_only($resp, array_keys($role)));
    }

    /** @test */
    public function 未授权用户不能删除角色()
    {
        $this->withExceptionHandling();

        $role = create(Role::class);

        $this->deleteJson(route('system.role.destroy', ['role' => $role->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以删除角色()
    {
        $this->signInSystemAdmin();

        $role = create(Role::class);

        $this->deleteJson(route('system.role.destroy', ['role' => $role->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing($role->getTable(), ['id' => $role->id]);
    }

    /** @test */
    public function 初始化角色无法删除()
    {
        $this->signInSystemAdmin();

        $initRole = $this->faker->randomElement(Constant::INIT_ROLES);

        $role = Role::where('key', $initRole)->first();

        $this->deleteJson(route('system.role.destroy', ['role' => $role->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 未授权用户不能查看角色()
    {
        $this->withExceptionHandling();

        $role = create(Role::class);

        $this->getJson(route('system.role.show', ['role' => $role->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看角色()
    {
        $this->signInSystemAdmin();

        /** @var Role $role */
        $role = create(Role::class);

        $resp = $this->getJson(route('system.role.show', ['role' => $role->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $fields = ['key', 'display_name', 'description'];
        $this->assertEquals(array_only($role->toArray(), $fields), array_only($resp, $fields));
    }

    /** @test */
    public function 未授权用户不能更新角色()
    {
        $this->withExceptionHandling();

        $role = create(Role::class);

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.role.update', ['role' => $role->id]), $update)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以更新角色()
    {
        $this->signInSystemAdmin();

        $role = create(Role::class);

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.role.update', ['role' => $role->id]), $update)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas($role->getTable(), array_merge(['id' => $role->id], $update));
    }

    /** @test */
    public function 授权用户不可以更新初始角色key()
    {
        $this->signInSystemAdmin();

        $role = Role::where('key', Constant::INIT_ROLES[0])->first();

        $update = ['key' => 'updated_key'];

        $this->patchJson(route('system.role.update', ['role' => $role->id]), $update)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 初始化角色key无法更新()
    {
        $this->signInSystemAdmin();

        $initRole = $this->faker->randomElement(Constant::INIT_ROLES);

        $role = Role::where('key', $initRole)->first();

        $this->deleteJson(route('system.role.destroy', ['role' => $role->id]),
            ['key' => 'other key'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以批量删除角色()
    {
        $this->signInSystemAdmin();

        $roles = create(Role::class, 5);

        $this->deleteJson(route('system.role.destroy', ['role' => $roles[0]->id]),
            ['ids' => $roles->pluck('id')->toArray()])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $roles->each(function ($role) {
            $this->assertDatabaseMissing($role->getTable(), ['id' => $role->id]);
        });
    }
}