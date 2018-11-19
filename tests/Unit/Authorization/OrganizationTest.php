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

class OrganizationTest extends TestCase
{

    /** @test */
    public function 组织拥有权限()
    {
        $org = create(Organization::class);
        $this->assertInstanceOf(Collection::class, $org->permissions);
    }

    /** @test */
    public function 组织拥有用户()
    {
        $org = create(Organization::class);
        $this->assertInstanceOf(Collection::class, $org->users);
    }

    /** @test */
    public function 组织拥有角色()
    {
        $org = create(Organization::class);
        $this->assertInstanceOf(Collection::class, $org->roles);
    }

    /** @test */
    public function 可以为组织分配或者解除权限()
    {
        $org = create(Organization::class);

        $permission = create(Permission::class);

        $org->attachPermissions($permission);

        $this->assertCount(1, $org->permissions);

        $org->detachPermissions($permission);
        $this->assertCount(0, $org->fresh()->permissions);
    }

    /** @test */
    public function 可以为组织分配或解除多个权限()
    {
        $org = create(Organization::class);

        $permissions = create(Permission::class, 5);

        $org->attachPermissions($permissions);

        $this->assertCount(5, $org->permissions);

        $org->detachPermissions($permissions);
        $this->assertCount(0, $org->fresh()->permissions);
    }

    /** @test */
    public function 可以为组织设置新权限()
    {
        $org = create(Organization::class);

        $permissions = create(Permission::class, 5);

        $org->attachPermissions($permissions);

        $this->assertCount(5, $org->permissions);

        $newPermissions = create(Permission::class, 3);

        $org->syncPermissions($newPermissions);

        $this->assertCount(3, $org->fresh()->permissions);
    }

    /** @test */
    public function 可以为组织分配或者解除用户()
    {
        $org = create(Organization::class);

        $user = create(User::class);

        $org->attachUsers($user);

        $this->assertCount(1, $org->users);

        $org->detachUsers($user);
        $this->assertCount(0, $org->fresh()->users);
    }

    /** @test */
    public function 可以为组织分配或者解除多个用户()
    {
        $org = create(Organization::class);

        $users = create(User::class, 5);

        $org->attachUsers($users);

        $this->assertCount(5, $org->users);

        $org->detachUsers($users);
        $this->assertCount(0, $org->fresh()->users);
    }

    /** @test */
    public function 可以为组织设置新用户()
    {
        $org = create(Organization::class);

        $users = create(User::class, 5);

        $org->attachUsers($users);

        $this->assertCount(5, $org->users);

        $newUsers = create(User::class, 3);

        $org->syncUsers($newUsers);

        $this->assertCount(3, $org->fresh()->users);
    }

    /** @test */
    public function 可以为组织分配或者解除角色()
    {
        $org = create(Organization::class);

        $role = create(Role::class);

        $org->attachRoles($role);

        $this->assertCount(1, $org->roles);

        $org->detachRoles($role);
        $this->assertCount(0, $org->fresh()->roles);
    }

    /** @test */
    public function 可以为组织分配或者解除多个角色()
    {
        $org = create(Organization::class);

        $roles = create(Role::class, 5);

        $org->attachRoles($roles);

        $this->assertCount(5, $org->roles);

        $org->detachRoles($roles);
        $this->assertCount(0, $org->fresh()->roles);
    }

    /** @test */
    public function 可以为组织设置新角色()
    {
        $org = create(Organization::class);

        $roles = create(Role::class, 5);

        $org->attachRoles($roles);

        $this->assertCount(5, $org->roles);

        $newRoles = create(Role::class, 3);

        $org->syncRoles($newRoles);

        $this->assertCount(3, $org->fresh()->roles);
    }

    /** @test */
    public function 组织删除后与之相关联的关系会自动解除()
    {
        $org = create(Organization::class);
        $role = create(Role::class);
        $user = create(User::class);
        $permission = create(Permission::class);

        $org->syncUsers($user);
        $org->syncRoles($role);
        $org->syncPermissions($permission);

        $this->assertCount(1, $org->users);
        $this->assertCount(1, $org->roles);
        $this->assertCount(1, $org->permissions);

        $org->delete();

        $this->assertCount(0, $user->refresh()->organizations);
        $this->assertCount(0, $role->refresh()->organizations);
        $this->assertCount(0, $permission->refresh()->organizations);
    }
}