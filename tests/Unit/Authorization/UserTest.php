<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 2:05 PM
 */

namespace Tests\Unit\Authorization;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Tests\TestCase;

class UserTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function 用户拥有权限()
    {
        $user = create(User::class);
        $this->assertInstanceOf(Collection::class, $user->permissions);
    }

    /** @test */
    public function 用户属于组织()
    {
        $user = create(User::class);
        $this->assertInstanceOf(Collection::class, $user->organizations);
    }

    /** @test */
    public function 用户拥有角色()
    {
        $user = create(User::class);
        $this->assertInstanceOf(Collection::class, $user->roles);
    }

    /** @test */
    public function 可以为用户分配或者解除权限()
    {
        $user = create(User::class);

        $permission = create(Permission::class);

        $user->attachPermissions($permission);

        $this->assertCount(1, $user->permissions);

        $user->detachPermissions($permission);
        $this->assertCount(0, $user->fresh()->permissions);
    }

    /** @test */
    public function 可以为用户分配或解除多个权限()
    {
        $user = create(User::class);

        $permissions = create(Permission::class, 5);

        $user->attachPermissions($permissions);

        $this->assertCount(5, $user->permissions);

        $user->detachPermissions($permissions);
        $this->assertCount(0, $user->fresh()->permissions);
    }

    /** @test */
    public function 可以为用户设置新权限()
    {
        $user = create(User::class);

        $permissions = create(Permission::class, 5);

        $user->attachPermissions($permissions);

        $this->assertCount(5, $user->permissions);

        $newPermissions = create(Permission::class, 3);

        $user->syncPermissions($newPermissions);

        $this->assertCount(3, $user->fresh()->permissions);
    }

    /** @test */
    public function 可以为用户分配或者解除用户()
    {
        $user = create(User::class);

        $organization = create(Organization::class);

        $user->attachOrganizations($organization);

        $this->assertCount(1, $user->organizations);

        $user->detachOrganizations($organization);
        $this->assertCount(0, $user->fresh()->organizations);
    }

    /** @test */
    public function 可以为用户分配或者解除多个组织()
    {
        $user = create(User::class);

        $organizations = create(Organization::class, 5);

        $user->attachOrganizations($organizations);

        $this->assertCount(5, $user->organizations);

        $user->detachOrganizations($organizations);
        $this->assertCount(0, $user->fresh()->organizations);
    }

    /** @test */
    public function 可以为用户设置新组织()
    {
        $user = create(User::class);

        $organizations = create(Organization::class, 5);

        $user->attachOrganizations($organizations);

        $this->assertCount(5, $user->organizations);

        $newOrganizations = create(Organization::class, 3);

        $user->syncOrganizations($newOrganizations);

        $this->assertCount(3, $user->fresh()->organizations);
    }

    /** @test */
    public function 可以为用户分配或者解除角色()
    {
        $user = create(User::class);

        $role = create(Role::class);

        $user->attachRoles($role);

        $this->assertCount(1, $user->roles);

        $user->detachRoles($role);
        $this->assertCount(0, $user->fresh()->roles);
    }

    /** @test */
    public function 可以为用户分配或者解除多个角色()
    {
        $user = create(User::class);

        $roles = create(Role::class, 5);

        $user->attachRoles($roles);

        $this->assertCount(5, $user->roles);

        $user->detachRoles($roles);
        $this->assertCount(0, $user->fresh()->roles);
    }

    /** @test */
    public function 可以为用户设置新角色()
    {
        $user = create(User::class);

        $roles = create(Role::class, 5);

        $user->attachRoles($roles);

        $this->assertCount(5, $user->roles);

        $newRoles = create(Role::class, 3);

        $user->syncRoles($newRoles);

        $this->assertCount(3, $user->fresh()->roles);
    }

    /** @test */
    public function 获取用户所有能力()
    {
        $user = create(User::class);

        $user->syncPermissions(create(Permission::class, ['key' => 'permission']));

        $role = create(Role::class);
        $role->syncPermissions(create(Permission::class, ['key' => 'role']));
        $user->syncRoles($role);

        $org = create(Organization::class);
        $org->syncPermissions(create(Permission::class, ['key' => 'org']));
        $user->syncOrganizations($org);

        $this->assertEquals(['permission', 'role', 'org'], $user->getAllAbilities());
    }
}