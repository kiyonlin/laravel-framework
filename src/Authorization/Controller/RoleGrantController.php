<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:33 PM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Authorization\Resource\RoleResource;
use Kiyon\Laravel\Authorization\Service\RoleService;
use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Support\Constant;

class RoleGrantController extends Controller
{

    /** @var RoleService */
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Role $role)
    {
        $userIds = (array)request('userIds', []);

        $role->attachUsers($userIds);

        return $this->respond();
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function permission(Role $role)
    {
        $permissionIds = (array)request('permissionIds', []);

        $role->syncPermissions($permissionIds);

        return $this->respond();
    }
}