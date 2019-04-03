<?php

namespace Kiyon\Laravel\Menu\Service;

use Illuminate\Support\Collection;
use Kiyon\Laravel\Authentication\Service\UserService;
use Kiyon\Laravel\Foundation\Service\RestfulService;
use Kiyon\Laravel\Menu\Contracts\MenuRepositoryContract;
use Kiyon\Laravel\Support\Constant;

class MenuService
{
    use RestfulService;

    /** @var MenuRepositoryContract $repo */
    protected $repo;

    public function __construct(MenuRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    /**
     * 获取 NgZorro 用户侧边菜单树
     *
     * @return array
     */
    public function getNgZorroSideNavMenuTree()
    {
        $menus = $this->repo->sideNav();

        return $this->generateNgZorroMenuTree($menus);
    }

    /**
     * 获取 NgZorro 用户顶部菜单树
     *
     * @return array
     */
    public function getNgZorroTopNavMenuTree()
    {
        $menus = $this->repo->topNav();

        return $this->generateNgZorroMenuTree($menus, false);
    }

    /**
     * 生成 NgZorro 结构的菜单树
     *
     * @param Collection $menus
     * @param bool $withPermission
     * @param int $parent_id
     * @param int $level 可用于控制缩进
     * @return array
     */
    private function generateNgZorroMenuTree(
        Collection $menus, $withPermission = true, $parent_id = Constant::MENU_ROOT_ID, $level = 1)
    {
        $root = [];

        foreach ($this->subMenus($menus, $parent_id) as $menu) {
            if (!$withPermission || can(auth()->user(), $menu->uniqueKey)) {
                $child = $menu->toArray();

                $child['level'] = $level;

                if (count($this->subMenus($menus, $currentId = $menu->id))) {
                    $child['children'] = $this->generateNgZorroMenuTree($menus, $withPermission, $currentId, $level + 1);
                } else {
                    $child['isLeaf'] = true;
                }

                $root[] = formatMenu($child);
            }
        }

        return $root;
    }

    /**
     * 过滤给定菜单id的子菜单
     *
     * @param Collection $menus
     * @param int $parent_id
     * @return Collection
     */
    private function subMenus(Collection $menus, $parent_id)
    {
        return $menus
            ->filter(function ($menu) use ($parent_id) {
                return $menu->parent_id == $parent_id;
            });
    }
}
