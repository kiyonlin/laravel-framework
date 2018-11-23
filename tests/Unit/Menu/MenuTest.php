<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 9:06 PM
 */

namespace Tests\Unit\Menu;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Menu\Model\Menu;
use Kiyon\Laravel\Menu\Service\MenuService;
use Tests\TestCase;

class MenuTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function 菜单有子菜单()
    {
        $menu = create(Menu::class);
        $this->assertInstanceOf(Collection::class, $menu->subMenus);
    }

    /** @test */
    public function 菜单有父菜单()
    {
        $menu = create(Menu::class);
        $this->assertNUll($menu->parentMenu);

        $subMenu = create(Menu::class, ['parent_id' => $menu->id]);
        $this->assertInstanceOf(Menu::class, $subMenu->parentMenu);
    }

    /** @test */
    public function 菜单的uniqueKey由各级的key累加起来()
    {
        $menu = create(Menu::class, ['key' => 'parent']);
        $this->assertEquals('parent', $menu->uniqueKey);

        $subMenu = create(Menu::class, ['key' => 'sub', 'parent_id' => $menu->id]);
        $this->assertEquals('parent.sub', $subMenu->uniqueKey);

        $subSubMenu = create(Menu::class, ['key' => 'sub sub', 'parent_id' => $subMenu->id]);
        $this->assertEquals('parent.sub.sub sub', $subSubMenu->uniqueKey);
    }

    /** @test */
    public function 根据权限获取NgZorro格式的菜单树()
    {
        $this->signIn();
        $user = auth()->user();

        $menuTree = [];

        $menus = create(Menu::class, 3);
        $user->attachPermissions(create(Permission::class, ['key' => $menus[0]->key]));

        $menuTree[] = $menus[0]->toArray() + ['isLeaf' => true];

        $parentMenu = create(Menu::class);
        $user->attachPermissions($parentPermission = create(Permission::class, ['key' => $parentMenu->key]));

        $subMenus = create(Menu::class, ['parent_id' => $parentMenu->id], 2);
        $user->attachPermissions(create(Permission::class, ['key' => $subMenus[0]->key, 'parent_id' => $parentPermission->id]));

        $subNode = [];

        $subNode[] = $subMenus[0]->toArray() + ['isLeaf' => true];

        $menuTree[] = $parentMenu->toArray() + ['children' => $subNode];

        /** @var MenuService $service */
        $service = app(MenuService::class);

        $actualMenuTree = $service->getNgZorroMenuTree();

        $this->assertEquals($menuTree, $actualMenuTree);
    }
}