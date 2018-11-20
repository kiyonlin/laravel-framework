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
use Kiyon\Laravel\Authentication\Repository\UserRepository;
use Kiyon\Laravel\Authentication\Service\UserService;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Support\Constant;
use Tests\TestCase;

class UserTest extends TestCase
{

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
    public function 用户删除后与之相关联的关系会自动解除()
    {
        $user = create(User::class);
        $org = create(Organization::class);
        $role = create(Role::class);
        $permission = create(Permission::class);

        $user->syncOrganizations($org);
        $user->syncRoles($role);
        $user->syncPermissions($permission);

        $this->assertCount(1, $user->organizations);
        $this->assertCount(1, $user->roles);
        $this->assertCount(1, $user->permissions);

        $user->delete();

        $this->assertCount(0, $org->refresh()->users);
        $this->assertCount(0, $role->refresh()->users);
        $this->assertCount(0, $permission->refresh()->users);
    }

    /** @test */
    public function 获取用户所有权限()
    {
        $user = create(User::class);

        $permissions = $this->setPermissions($user);

        /** @var UserRepository $repo */
        $repo = resolve(UserRepository::class);
        $actualPermissions = $repo->getAllPermissions($user);

        $this->assertEquals($permissions->sortBy('id')->pluck('id')->toArray(),
            $actualPermissions->sortBy('id')->pluck('id')->toArray());
    }

    /** @test */
    public function 获取用户所有能力()
    {
        $user = create(User::class);

        $permissions = $this->setPermissions($user);

        $abilities = $permissions->sortBy('id')->pluck('ability')->toArray();

        /** @var UserService $service */
        $service = resolve(UserService::class);
        $actualAbilities = $service->getAllAbilities($user);

        $this->assertEquals($abilities, $actualAbilities);
    }

    /** @test */
    public function 判断用户是否拥有权限()
    {
        $user = create(User::class);

        $this->setPermissions($user);

        /** @var UserService $service */
        $service = resolve(UserService::class);

        $canDoUser = $service->can($user, 'user');
        $this->assertTrue($canDoUser);

        $canDoRoleAndOrg = $service->can($user, ['role', 'org']);
        $this->assertTrue($canDoRoleAndOrg);

        $cannotDoExist = $service->can($user, 'not exist');
        $this->assertFalse($cannotDoExist);
    }

    /** @test */
    public function 系统管理员无视权限可以做任何操作()
    {
        $user = createSystemAdmin();

        /** @var UserService $service */
        $service = resolve(UserService::class);

        $canDoUser = $service->can($user, 'user');
        $this->assertTrue($canDoUser);

        $canDoRole = $service->can($user, 'role');
        $this->assertTrue($canDoRole);

        $cannotDoExist = $service->can($user, 'not exist');
        $this->assertTrue($cannotDoExist);
    }

    /**
     * @param User $user
     * @return Collection
     */
    private function setPermissions(User $user)
    {
        $permissions = collect([]);

        $userPermission = create(Permission::class, ['key' => 'user'], 1);
        $userSubPermission = create(Permission::class, ['key' => 'userSub', 'parent_id' => $userPermission[0]->id], 1);
        $user->syncPermissions($userPermission->merge($userSubPermission));
        $permissions = $permissions->merge($userPermission);
        $permissions = $permissions->merge($userSubPermission);

        $role = create(Role::class);
        $rolePermission = create(Permission::class, ['key' => 'role'], 1);
        $role->syncPermissions($rolePermission);
        $user->syncRoles($role);
        $permissions = $permissions->merge($rolePermission);

        $org = create(Organization::class);
        $orgRole = create(Role::class);
        $orgRolePermission = create(Permission::class, ['key' => 'orgRole'], 1);
        $orgRole->syncPermissions($orgRolePermission);
        $org->syncRoles($orgRole);
        $orgPermission = create(Permission::class, ['key' => 'org'], 1);
        $org->syncPermissions($orgPermission);
        $user->syncOrganizations($org);
        $permissions = $permissions->merge($orgRolePermission);
        $permissions = $permissions->merge($orgPermission);

        // 制造重复
        $user->attachPermissions($rolePermission);
        $user->attachPermissions($orgRolePermission);
        $user->attachPermissions($orgPermission);

        return $permissions;
    }
}