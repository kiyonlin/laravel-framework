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
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Tests\TestCase;

class PermissionTest extends TestCase
{

    use DatabaseMigrations;

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
}