<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Authorization\Service;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Contracts\GrantPermissionContract;
use Kiyon\Laravel\Authorization\Contracts\PermissionRepositoryContract;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Role;
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
     *
     * @return mixed
     */
    public function getNgZorroCheckedKeys(GrantPermissionContract $permissionOwner)
    {
        return $permissionOwner->permissions->pluck('key')->toArray();
    }

    /**
     * 获取 NgZorro 用户权限树
     *
     * @param Authenticatable $user
     * @param array           $editableIds
     *
     * @return array
     */
    public function getNgZorroUserPermissionTree(User $user)
    {
        $permissions = $this->repo->all()->sortBy('sort');

        $userPermissionIds = $user->permissions->pluck('id')->toArray();

        $rolePermissionIds = $user->roles->reduce(function (array $ids, Role $role) {
            return array_merge($ids, $role->permissions->pluck('id')->toArray());
        }, []);

        $organizationPermissionIds = $user->organizations->reduce(function (array $ids, Organization $organization) {
            return array_merge($ids, $organization->permissions->pluck('id')->toArray());
        }, []);

        $indirectPermissionIds = [
            'role'         => $rolePermissionIds,
            'organization' => $organizationPermissionIds
        ];

        $ownedIds = array_unique(array_merge($userPermissionIds, $rolePermissionIds, $organizationPermissionIds));

        return [$ownedIds, $this->generateNgZorroPermissionTree($permissions, $indirectPermissionIds, $userPermissionIds)];
    }

    /**
     * 生成 NgZorro 结构的权限树
     *
     * @param Collection $permissions
     * param array $indirectPermissionIds
     * param array $editableIds
     * @param int        $parent_id
     *
     * @return array
     */
    private function generateNgZorroPermissionTree(
        Collection $permissions, $indirectPermissionIds, $editableIds, $parent_id = Constant::PERMISSION_ROOT_ID)
    {
        $root = [];

        foreach ($this->subPermissions($permissions, $parent_id) as $permission) {
            $child = ['key' => $permission->id];

            $title = $permission->display_name;

            list($disableCheckbox, $extraTitle) = $this->initDisableCheckBox($permission->id, $indirectPermissionIds, $editableIds);

            $title .= $extraTitle;

            $child['disableCheckbox'] = $disableCheckbox;
            $child['title'] = $title;

            if (count($this->subPermissions($permissions, $currentId = $permission->id))) {
                $child['children'] = $this->generateNgZorroPermissionTree($permissions, $indirectPermissionIds, $editableIds, $currentId);
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
     * @param int        $parent_id
     *
     * @return Collection
     */
    private function subPermissions(Collection $permissions, $parent_id)
    {
        return $permissions
            ->filter(function ($permission) use ($parent_id) {
                return $permission->parent_id == $parent_id;
            });
    }

    /**
     * @param       $id
     * @param array $indirectPermissionIds
     * @param array $editableIds
     *
     * @return array
     */
    private function initDisableCheckBox($id, $indirectPermissionIds, $editableIds)
    {
        if (empty($indirectPermissionIds)) {
            return [false, ''];
        }

        $extraTitle = [];

        $disableCheckbox = false;

        if (in_array($id, $indirectPermissionIds['role'])) {
            $extraTitle[] = '角色';
            $disableCheckbox = true;
        }

        if (in_array($id, $indirectPermissionIds['organization'])) {
            $extraTitle[] = '组织';
            $disableCheckbox = true;
        }

        if (in_array($id, $editableIds)) {
            $disableCheckbox = false;
        }

        $title = count($extraTitle) ? '(' . implode(',', $extraTitle) . ')' : '';

        return [$disableCheckbox, $title];
    }
}