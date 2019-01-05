<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Authorization\Service;


use Illuminate\Support\Collection;
use Kiyon\Laravel\Authorization\Contracts\GrantPermissionContract;
use Kiyon\Laravel\Authorization\Contracts\PermissionRepositoryContract;
use Kiyon\Laravel\Foundation\Service\RestfulService;
use Kiyon\Laravel\Support\Constant;

class PermissionService
{

    use RestfulService;

    /** @var PermissionRepositoryContract $repo */
    protected $repo;

    public function __construct(PermissionRepositoryContract $repo)
    {
        $this->repo = $repo;
    }

    /**
     * 获取权限拥有者的权限 key 数组
     *
     * @param GrantPermissionContract $permissionOwner
     * @return mixed
     */
    public function getNgZorroCheckedKeys(GrantPermissionContract $permissionOwner)
    {
        return $permissionOwner->permissions->pluck('key')->toArray();
    }

    /**
     * 获取 NgZorro 用户权限树
     *
     * @return array
     */
    public function getNgZorroPermissionTree()
    {
        $permissions = $this->repo->all();

        return $this->generateNgZorroPermissionTree($permissions);
    }

    /**
     * 生成 NgZorro 结构的权限树
     *
     * @param Collection $permissions
     * @param int $parent_id
     * @return array
     */
    private function generateNgZorroPermissionTree(
        Collection $permissions, $parent_id = Constant::PERMISSION_ROOT_ID)
    {
        $root = [];

        foreach ($this->subPermissions($permissions, $parent_id) as $permission) {
            $child = [
                'title' => $permission->display_name,
                'key'   => $permission->key,
            ];

            if (count($this->subPermissions($permissions, $currentId = $permission->id))) {
                $child['children'] = $this->generateNgZorroPermissionTree($permissions, $currentId);
            } else {
                $child['isLeaf'] = true;
            }

            $root[] = $child;
        }

        return $root;
    }

    /**
     * 过滤给定权限id的子权限
     *
     * @param Collection $permissions
     * @param int $parent_id
     * @return Collection
     */
    private function subPermissions(Collection $permissions, $parent_id)
    {
        return $permissions
            ->filter(function ($permission) use ($parent_id) {
                return $permission->parent_id == $parent_id;
            });
    }
}