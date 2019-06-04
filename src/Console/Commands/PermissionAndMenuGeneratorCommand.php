<?php

namespace Kiyon\Laravel\Console\Commands;

use Closure;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Console\Command;
use Kiyon\Laravel\Menu\Model\Menu;
use Kiyon\Laravel\Support\Constant;

class PermissionAndMenuGeneratorCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintain:permissions-and-menus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '维护权限和菜单数据';

    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * An array of all the registered routes.
     *
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    /**
     * Create a new route command instance.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $abilities = $this->getAbilitiesInRouteMiddleware();

        $this->updatePermissions($abilities);

        $this->updateMenus($abilities);

        return true;
    }

    /**
     * get routes with ability middleware
     *
     * @return \Illuminate\Support\Collection
     */
    private function getAbilitiesInRouteMiddleware()
    {
        /** @var \Illuminate\Routing\RouteCollection routes */
        $routes = collect($this->laravel->make('router')->getRoutes())
            ->map(function (Route $route) {
                return collect($route->gatherMiddleware())
                    ->filter(function ($middleware) {
                        return !($middleware instanceof Closure) && Str::contains($middleware, 'ability:');
                    })
                    ->map(function ($middleware) {
                        return Str::replaceFirst('ability:', '', $middleware);
                    });
            });

        return $routes->flatten();
    }

    /**
     * @param Collection $abilities
     */
    protected function updatePermissions($abilities)
    {
        foreach ($abilities as $ability) {
            $permissionKeys = explode('.', $ability);
            array_reduce($permissionKeys, function ($parent_id, $permissionKey) {
                $permission = Permission::where(['parent_id' => $parent_id, 'key' => $permissionKey])->first();
                if (!$permission) {
                    $permission = Permission::create([
                        'parent_id'    => $parent_id,
                        'key'          => $permissionKey,
                        'display_name' => $this->generalPermissionName($permissionKey)
                    ]);
                }

                return $permission->id;
            }, Constant::PERMISSION_ROOT_ID);
        }
    }

    /**
     * @param Collection $abilities
     */
    protected function updateMenus($abilities)
    {
        foreach ($abilities as $ability) {
            $menuKeys = explode('.', $ability);

            $count = count($menuKeys);

            array_reduce($menuKeys, function ($carry, $menuKey) use ($count) {
                if ($carry['level'] > 1 && $carry['level'] == $count) return $carry;

                $menu = Menu::where(['parent_id' => $carry['parent_id'], 'key' => $menuKey])->first();

                if (!$menu) {
                    $menu = Menu::create([
                        'parent_id'    => $carry['parent_id'],
                        'key'          => $menuKey,
                        'display_name' => $menuKey,
                        'type'         => Constant::MENU_SIDE_NAV,
                        'group'        => $carry['level'] < $count,
                        'link'         => $menuKey,
                    ]);
                }

                return ['parent_id' => $menu->id, 'level' => $carry['level'] + 1];
            }, ['parent_id' => Constant::MENU_ROOT_ID, 'level' => 1]);
        }
    }

    /**
     * 根据权限key自动生成常用的权限名称
     *
     * @param string $permissionKey
     *
     * @return string
     */
    private function generalPermissionName($permissionKey)
    {
        $generalName = [
            'index'              => '列表',
            'store'              => '新建',
            'show'               => '查看',
            'update'             => '更新',
            'destroy'            => '删除',
            'grant-user'         => '设置用户',
            'grant-permission'   => '设置权限',
            'grant-role'         => '设置角色',
            'grant-organization' => '设置组织',
        ];
        return $generalName[$permissionKey] ?? $permissionKey;
    }
}
