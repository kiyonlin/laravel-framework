<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 2:05 PM
 */

namespace Tests\Unit\Authorization;


use Illuminate\Support\Collection;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{

    /** @test */
    public function 角色拥有权限()
    {
        $role = create(Role::class);
        $this->assertInstanceOf(Collection::class, $role->permissions);
    }

    /** @test */
    public function 角色属于用户()
    {
        $role = create(Role::class);
        $this->assertInstanceOf(Collection::class, $role->users);
    }

    /** @test */
    public function 角色属于组织()
    {
        $role = create(Role::class);
        $this->assertInstanceOf(Collection::class, $role->organizations);
    }

    /** @test */
    public function 可以为角色分配或者解除权限()
    {
        $role = create(Role::class);

        $permission = create(Permission::class);

        $role->attachPermissions($permission);

        $this->assertCount(1, $role->permissions);

        $role->detachPermissions($permission);
        $this->assertCount(0, $role->fresh()->permissions);
    }

    /** @test */
    public function 可以为角色分配或解除多个权限()
    {
        $role = create(Role::class);

        $permissions = create(Permission::class, 5);

        $role->attachPermissions($permissions);

        $this->assertCount(5, $role->permissions);

        $role->detachPermissions($permissions);
        $this->assertCount(0, $role->fresh()->permissions);
    }

    /** @test */
    public function 可以为角色设置新权限()
    {
        $role = create(Role::class);

        $permissions = create(Permission::class, 5);

        $role->attachPermissions($permissions);

        $this->assertCount(5, $role->permissions);

        $newPermissions = create(Permission::class, 3);

        $role->syncPermissions($newPermissions);

        $this->assertCount(3, $role->fresh()->permissions);
    }

    /** @test */
    public function 角色删除后与之相关联的关系会自动解除()
    {
        $role = create(Role::class);
        $user = create(User::class);
        $org = create(Organization::class);
        $permission = create(Permission::class);

        $user->syncRoles($role);
        $org->syncRoles($role);
        $role->syncPermissions($permission);

        $this->assertCount(1, $user->roles);
        $this->assertCount(1, $org->roles);
        $this->assertCount(1, $role->permissions);

        $role->delete();

        $this->assertCount(0, $user->refresh()->roles);
        $this->assertCount(0, $org->refresh()->roles);
        $this->assertCount(0, $permission->refresh()->roles);
    }
}