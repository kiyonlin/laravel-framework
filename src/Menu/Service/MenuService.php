<?php

namespace Kiyon\Laravel\Menu\Service;

use Illuminate\Support\Collection;
use Kiyon\Laravel\Authentication\Service\UserService;
use Kiyon\Laravel\Menu\Contracts\MenuRepositoryContract;
use Kiyon\Laravel\Support\Constant;

class MenuService
{

    /** @var MenuRepositoryContract $repo */
    public $repo;

    /** @var UserService $userService */
    public $userService;

    public function __construct(MenuRepositoryContract $repo, UserService $userService)
    {
        $this->repo = $repo;

        $this->userService = $userService;
    }

    /**
     * 获取 NgZorro 用户菜单树
     *
     * @return array
     */
    public function getNgZorroMenuTree()
    {
        $menus = $this->repo->all();

        return $this->generateNgZorroMenuTree($menus);
    }

    /**
     * 生成 NgZorro 结构的菜单树
     *
     * @param Collection $menus
     * @param int $parent_id
     * @return array
     */
    private function generateNgZorroMenuTree(
        Collection $menus, $parent_id = Constant::MENU_ROOT_ID)
    {
        $root = [];

        foreach ($this->subMenus($menus, $parent_id) as $menu) {
            $child = $menu->toArray();

            if (count($this->subMenus($menus, $currentId = $menu->id))) {
                $child['children'] = $this->generateNgZorroMenuTree($menus, $currentId);
            } else {
                $child['isLeaf'] = true;
            }

            if ($this->userService->can(auth()->user(), $menu->uniqueKey)) {
                $root[] = $child;
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
