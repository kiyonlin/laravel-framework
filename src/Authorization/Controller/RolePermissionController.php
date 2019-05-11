<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:33 PM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Authorization\Service\PermissionService;
use Kiyon\Laravel\Authorization\Service\RoleService;
use Kiyon\Laravel\Foundation\Routing\Controller;

class RolePermissionController extends Controller
{

    /** @var RoleService */
    protected $service;

    /** @var PermissionService */
    protected $permissionService;

    public function __construct(RoleService $service, PermissionService $permissionService)
    {
        $this->service = $service;
        $this->permissionService = $permissionService;
    }

    public function show(Role $role)
    {
        $nodes = $this->permissionService->getNgZorroPermissionTree();

        $defaultChecked = $role->permissions->pluck('id')->toArray();

        return $this->respond(compact('defaultChecked', 'nodes'));
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role)
    {
        $permissionIds = (array)request('permissionIds', []);

        $role->syncPermissions($permissionIds);

        return $this->respond();
    }
}