<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 10:05 AM
 */

namespace Kiyon\Laravel\Authentication\Service;

use Illuminate\Support\Collection;
use Kiyon\Laravel\Authentication\Contracts\UserRepositoryContract;
use Kiyon\Laravel\Authentication\Model\User;

class UserService
{

    /**
     * @var User
     */
    protected $model;

    /**
     * @var UserRepositoryContract
     */
    protected $repo;

    public function __construct(User $model, UserRepositoryContract $repo)
    {
        $this->model = $model;
        $this->repo = $repo;
    }

    /**
     * 获取用户所有的能力
     *
     * @param User $user
     * @return array
     */
    public function getAllAbilities(User $user)
    {
        $permissions = $this->repo->getAllPermissions($user);

        return $permissions->sortBy('id')->pluck('ability')->toArray();
    }

    /**
     * 获取 NgZorro 用户权限树
     *
     * @param User $user
     * @return array
     */
    public function getNgZorroPermissionTree(User $user)
    {
        $permissions = $this->repo->getAllPermissions($user);

        return $this->generateNgZorroPermissionTree($permissions);
    }

    /**
     * 生成 NgZorro 结构的权限树
     *
     * @param Collection $permissions
     * @param int $parent_id
     * @return array
     */
    private function generateNgZorroPermissionTree(Collection $permissions, $parent_id = 0)
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