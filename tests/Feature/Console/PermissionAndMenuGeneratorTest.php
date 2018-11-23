<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/23
 * Time: 10:50 AM
 */

namespace Tests\Feature\Console;


use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Menu\Model\Menu;
use Tests\TestCase;

class PermissionAndMenuGeneratorTest extends TestCase
{

    /** @var Permission $permissionModel */
    protected $permissionModel;

    /** @var Menu $menuModel */
    protected $menuModel;

    protected function setUp()
    {
        parent::setUp();

        $this->initRouts();

        $this->permissionModel = app(Permission::class);
        $this->permissionModel->truncate();

        $this->menuModel = app(Menu::class);
        $this->menuModel->truncate();
    }

    /** @test */
    public function 根据路由新建权限()
    {
        $this->assertCount(0, $this->permissionModel->all());

        $this->artisan('maintain:permissions-and-menus')->run();

        $table = (new Permission())->getTable();

        $this->assertCount(15, $this->permissionModel->all());

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'system']);

        $systemPermission = app(Permission::class)->where(['parent_id' => 0, 'key' => 'system'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemPermission->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemPermission->id, 'key' => 'bar']);

        $systemFooPermission = app(Permission::class)->where(['parent_id' => $systemPermission->id, 'key' => 'foo'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemFooPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemFooPermission->id, 'key' => 'store']);

        $systemBarPermission = app(Permission::class)->where(['parent_id' => $systemPermission->id, 'key' => 'bar'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemBarPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemBarPermission->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'app']);

        $appPermission = app(Permission::class)->where(['parent_id' => 0, 'key' => 'app'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appPermission->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $appPermission->id, 'key' => 'bar']);

        $appFooPermission = app(Permission::class)->where(['parent_id' => $appPermission->id, 'key' => 'foo'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appFooPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $appFooPermission->id, 'key' => 'store']);

        $appBarPermission = app(Permission::class)->where(['parent_id' => $appPermission->id, 'key' => 'bar'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appBarPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $appBarPermission->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'setting']);
    }

    /** @test */
    public function 根据路由更新权限()
    {
        $systemPermission = create(Permission::class, ['key' => 'system']);

        create(Permission::class, ['parent_id' => $systemPermission->id, 'key' => 'foo']);

        $this->assertCount(2, $this->permissionModel->all());

        $this->artisan('maintain:permissions-and-menus')->run();

        $this->assertCount(15, $this->permissionModel->all());

        $table = (new Permission())->getTable();

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'system']);

        $systemPermission = app(Permission::class)->where(['parent_id' => 0, 'key' => 'system'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemPermission->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemPermission->id, 'key' => 'bar']);

        $systemFooPermission = app(Permission::class)->where(['parent_id' => $systemPermission->id, 'key' => 'foo'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemFooPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemFooPermission->id, 'key' => 'store']);

        $systemBarPermission = app(Permission::class)->where(['parent_id' => $systemPermission->id, 'key' => 'bar'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemBarPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemBarPermission->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'app']);

        $appPermission = app(Permission::class)->where(['parent_id' => 0, 'key' => 'app'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appPermission->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $appPermission->id, 'key' => 'bar']);

        $appFooPermission = app(Permission::class)->where(['parent_id' => $appPermission->id, 'key' => 'foo'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appFooPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $appFooPermission->id, 'key' => 'store']);

        $appBarPermission = app(Permission::class)->where(['parent_id' => $appPermission->id, 'key' => 'bar'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appBarPermission->id, 'key' => 'index']);
        $this->assertDatabaseHas($table, ['parent_id' => $appBarPermission->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'setting']);
    }

    /** @test */
    public function 根据路由新建菜单()
    {
        $this->assertCount(0, $this->menuModel->all());

        $this->artisan('maintain:permissions-and-menus')->run();

        $table = (new Menu())->getTable();

        $this->assertCount(7, $this->menuModel->all());

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'system']);

        $systemMenu = app(Menu::class)->where(['parent_id' => 0, 'key' => 'system'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemMenu->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemMenu->id, 'key' => 'bar']);

        $systemFooMenu = app(Menu::class)->where(['parent_id' => $systemMenu->id, 'key' => 'foo'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $systemFooMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $systemFooMenu->id, 'key' => 'store']);

        $systemBarMenu = app(Menu::class)->where(['parent_id' => $systemMenu->id, 'key' => 'bar'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $systemBarMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $systemBarMenu->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'app']);

        $appMenu = app(Menu::class)->where(['parent_id' => 0, 'key' => 'app'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appMenu->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $appMenu->id, 'key' => 'bar']);

        $appFooMenu = app(Menu::class)->where(['parent_id' => $appMenu->id, 'key' => 'foo'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $appFooMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $appFooMenu->id, 'key' => 'store']);

        $appBarMenu = app(Menu::class)->where(['parent_id' => $appMenu->id, 'key' => 'bar'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $appBarMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $appBarMenu->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'setting']);
    }

    /** @test */
    public function 根据路由更新菜单()
    {
        $systemMenu = create(Menu::class, ['key' => 'system']);

        create(Menu::class, ['parent_id' => $systemMenu->id, 'key' => 'foo']);

        $this->assertCount(2, $this->menuModel->all());

        $this->artisan('maintain:permissions-and-menus')->run();

        $this->assertCount(7, $this->menuModel->all());

        $table = (new Menu())->getTable();

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'system']);

        $systemMenu = app(Menu::class)->where(['parent_id' => 0, 'key' => 'system'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $systemMenu->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $systemMenu->id, 'key' => 'bar']);

        $systemFooMenu = app(Menu::class)->where(['parent_id' => $systemMenu->id, 'key' => 'foo'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $systemFooMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $systemFooMenu->id, 'key' => 'store']);

        $systemBarMenu = app(Menu::class)->where(['parent_id' => $systemMenu->id, 'key' => 'bar'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $systemBarMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $systemBarMenu->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'app']);

        $appMenu = app(Menu::class)->where(['parent_id' => 0, 'key' => 'app'])->first();
        $this->assertDatabaseHas($table, ['parent_id' => $appMenu->id, 'key' => 'foo']);
        $this->assertDatabaseHas($table, ['parent_id' => $appMenu->id, 'key' => 'bar']);

        $appFooMenu = app(Menu::class)->where(['parent_id' => $appMenu->id, 'key' => 'foo'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $appFooMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $appFooMenu->id, 'key' => 'store']);

        $appBarMenu = app(Menu::class)->where(['parent_id' => $appMenu->id, 'key' => 'bar'])->first();
        $this->assertDatabaseMissing($table, ['parent_id' => $appBarMenu->id, 'key' => 'index']);
        $this->assertDatabaseMissing($table, ['parent_id' => $appBarMenu->id, 'key' => 'store']);

        $this->assertDatabaseHas($table, ['parent_id' => 0, 'key' => 'setting']);
    }

    /**
     * 初始化路由
     */
    protected function initRouts()
    {
        $router = $this->getRouter();

        $router->get('system/foo', ['middleware' => ['ability:system.foo.index', 'auth'], function () {
            return 'foo.index';
        }]);
        $router->post('system/foo', ['middleware' => ['ability:system.foo.store', 'auth'], function () {
            return 'foo.store';
        }]);
        $router->get('system/bar', ['middleware' => ['ability:system.bar.index', 'auth'], function () {
            return 'bar.index';
        }]);
        $router->post('system/bar', ['middleware' => ['ability:system.bar.store', 'auth'], function () {
            return 'bar.store';
        }]);

        $router->get('app/foo', ['middleware' => ['ability:app.foo.index', 'auth'], function () {
            return 'foo.index';
        }]);
        $router->post('app/foo', ['middleware' => ['ability:app.foo.store', 'auth'], function () {
            return 'foo.store';
        }]);
        $router->get('app/bar', ['middleware' => ['ability:app.bar.index', 'auth'], function () {
            return 'bar.index';
        }]);
        $router->post('app/bar', ['middleware' => ['ability:app.bar.store', 'auth'], function () {
            return 'bar.store';
        }]);

        $router->get('setting', ['middleware' => ['ability:setting', 'auth'], function () {
            return 'setting';
        }]);
    }


    /**
     * 获取置空所有路由的路由器
     *
     * @return Router
     */
    protected function getRouter()
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = app(\Illuminate\Routing\Router::class);

        $router->setRoutes(new RouteCollection);

        return $router;
    }
}