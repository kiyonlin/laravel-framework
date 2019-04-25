<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Authorization;


use Kiyon\Laravel\Authorization\Model\Permission;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class PermissionTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不能查看权限列表()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.permission.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看权限列表()
    {
        $this->signInSystemAdmin();

        create(Permission::class, 5);

        $resp = $this->getJson(route('system.permission.index'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount(5, $resp);
    }

    /** @test */
    public function 未授权用户不能添加权限()
    {
        $this->withExceptionHandling();

        $permission = raw(Permission::class);

        $this->postJson(route('system.permission.store'), $permission)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以添加权限()
    {
        $this->signInSystemAdmin();

        $permission = raw(Permission::class);

        $resp = $this->postJson(route('system.permission.store'), $permission)
            ->assertStatus(Response::HTTP_CREATED)
            ->json();

        $this->assertEquals($permission, array_only($resp, array_keys($permission)));
    }

    /** @test */
    public function 未授权用户不能删除权限()
    {
        $this->withExceptionHandling();

        $permission = create(Permission::class);

        $this->deleteJson(route('system.permission.destroy', ['permission' => $permission->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以删除权限()
    {
        $this->signInSystemAdmin();

        $permission = create(Permission::class);

        $this->deleteJson(route('system.permission.destroy', ['permission' => $permission->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing($permission->getTable(), ['id' => $permission->id]);
    }

    /** @test */
    public function 未授权用户不能查看权限()
    {
        $this->withExceptionHandling();

        $permission = create(Permission::class);

        $this->getJson(route('system.permission.show', ['permission' => $permission->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看权限()
    {
        $this->signInSystemAdmin();

        /** @var Permission $permission */
        $permission = create(Permission::class);

        $resp = $this->getJson(route('system.permission.show', ['permission' => $permission->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $fields = ['key', 'display_name', 'description'];
        $this->assertEquals(array_only($permission->toArray(), $fields), array_only($resp, $fields));
    }

    /** @test */
    public function 未授权用户不能更新权限()
    {
        $this->withExceptionHandling();

        $permission = create(Permission::class);

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.permission.update', ['permission' => $permission->id]), $update)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以更新权限()
    {
        $this->signInSystemAdmin();

        $permission = create(Permission::class);

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.permission.update', ['permission' => $permission->id]), $update)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas($permission->getTable(), array_merge(['id' => $permission->id], $update));
    }

    /** @test */
    public function 授权用户可以批量删除权限()
    {
        $this->signInSystemAdmin();

        $permissions = create(Permission::class, 5);

        $this->deleteJson(route('system.permission.destroy', ['permission' => $permissions[0]->id]),
            ['ids' => $permissions->pluck('id')->toArray()])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $permissions->each(function ($permission) {
            $this->assertDatabaseMissing($permission->getTable(), ['id' => $permission->id]);
        });
    }
}