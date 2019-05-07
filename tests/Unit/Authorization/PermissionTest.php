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
use Kiyon\Laravel\Authorization\Service\PermissionService;
use Tests\TestCase;

class PermissionTest extends TestCase
{

    /** @test */
    public function 权限拥有子权限()
    {
        $permission = create(Permission::class);
        $this->assertInstanceOf(Collection::class, $permission->subPermissions);
    }

    /** @test */
    public function 权限拥有父权限()
    {
        $permission = create(Permission::class);
        $this->assertNull($permission->parentPermission);

        $subPermission = create(Permission::class, ['parent_id' => $permission->id]);
        $this->assertInstanceOf(Permission::class, $subPermission->parentPermission);
    }

    /** @test */
    public function 权限自动维护自己的层级()
    {
        $permission = create(Permission::class, ['key' => 'parent']);

        $this->assertEquals(1, $permission->level);

        $subPermission = create(Permission::class, ['key' => 'sub', 'parent_id' => $permission->id]);

        $this->assertEquals(2, $subPermission->level);

        $subSubPermission = create(Permission::class, ['key' => 'sub sub', 'parent_id' => $subPermission->id]);

        $this->assertEquals(3, $subSubPermission->level);

        $subPermission->update(['parent_id' => 0]);
        $this->assertEquals(1, $subPermission->level);
        $this->assertEquals(2, $subSubPermission->refresh()->level);
    }

    /** @test */
    public function 权限的能力由各级的key累加起来()
    {
        $permission = create(Permission::class, ['key' => 'parent']);
        $this->assertEquals('parent', $permission->ability);

        $subPermission = create(Permission::class, ['key' => 'sub', 'parent_id' => $permission->id]);
        $this->assertEquals('parent.sub', $subPermission->ability);

        $subSubPermission = create(Permission::class, ['key' => 'sub sub', 'parent_id' => $subPermission->id]);
        $this->assertEquals('parent.sub.sub sub', $subSubPermission->ability);
    }

    /** @test */
    public function 权限删除后与之相关联的关系会自动解除()
    {
        $user = create(User::class);
        $role = create(Role::class);
        $org = create(Organization::class);
        $permission = create(Permission::class);

        $user->syncPermissions($permission);
        $role->syncPermissions($permission);
        $org->syncPermissions($permission);

        $this->assertCount(1, $user->permissions);
        $this->assertCount(1, $role->permissions);
        $this->assertCount(1, $org->permissions);

        $permission->delete();

        $this->assertCount(0, $user->refresh()->permissions);
        $this->assertCount(0, $role->refresh()->permissions);
        $this->assertCount(0, $org->refresh()->permissions);
    }

    /** @test */
    public function 获取NgZorro格式的权限树()
    {
        $permissionTree = [];

        $permissions = create(Permission::class, 3);

        foreach ($permissions as $permission) {
            $permissionTree[] = [
                'id'     => $permission->id,
                'title'  => $permission->display_name,
                'key'    => $permission->key,
                'sort'   => $permission->sort,
                'isLeaf' => true,
            ];
        }

        $parentPermission = create(Permission::class);
        $subPermissions = create(Permission::class, ['parent_id' => $parentPermission->id], 2);
        $subNode = [];

        foreach ($subPermissions as $permission) {
            $subNode[] = [
                'id'     => $permission->id,
                'title'  => $permission->display_name,
                'key'    => $permission->key,
                'sort'   => $permission->sort,
                'isLeaf' => true,
            ];
        }

        $permissionTree[] = [
            'id'       => $parentPermission->id,
            'title'    => $parentPermission->display_name,
            'key'      => $parentPermission->key,
            'sort'     => $permission->sort,
            'children' => $subNode
        ];

        /** @var PermissionService $service */
        $service = app(PermissionService::class);

        $actualPermissionTree = $service->getNgZorroPermissionTree();

        $this->assertEquals($permissionTree, $actualPermissionTree);
    }

    /** @test */
    public function 权限拥有者可以获取所有权限key来标识权限树上已拥有的权限()
    {
        /** @var PermissionService $service */
        $service = app(PermissionService::class);

        $permissions = create(Permission::class, 5);
        $keys = $permissions->pluck('key')->toArray();

        $user = create(User::class);
        $user->syncPermissions($permissions);

        $this->assertEquals($keys, $service->getNgZorroCheckedKeys($user));

        $role = create(Role::class);
        $role->syncPermissions($permissions);

        $this->assertEquals($keys, $service->getNgZorroCheckedKeys($role));

        $org = create(Organization::class);
        $org->syncPermissions($permissions);

        $this->assertEquals($keys, $service->getNgZorroCheckedKeys($org));
    }
}