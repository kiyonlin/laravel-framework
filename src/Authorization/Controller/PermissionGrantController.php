<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:33 PM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Service\PermissionService;
use Kiyon\Laravel\Foundation\Routing\Controller;

class PermissionGrantController extends Controller
{

    /** @var PermissionService */
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Permission $permission)
    {
        $userIds = (array)request('userIds', []);

        $permission->attachUsers($userIds);

        return $this->respond();
    }

    /**
 * @param Permission $permission
 *
 * @return \Illuminate\Http\JsonResponse
 */
    public function role(Permission $permission)
    {
        $roleIds = (array)request('roleIds', []);

        $permission->syncRoles($roleIds);

        return $this->respond();
    }

    /**
     * @param Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function organization(Permission $permission)
    {
        $organizationIds = (array)request('organizationIds', []);

        $permission->syncOrganizations($organizationIds);

        return $this->respond();
    }
}