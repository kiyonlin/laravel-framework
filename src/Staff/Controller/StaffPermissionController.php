<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 9:19 AM
 */

namespace Kiyon\Laravel\Staff\Controller;


use Kiyon\Laravel\Authorization\Service\PermissionService;
use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Staff\Resource\StaffResource;

class StaffPermissionController extends Controller
{
    /** @var PermissionService */
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @param Staff $staff
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Staff $staff)
    {
        $grantPermissionTree = $this->permissionService->getNgZorroGrantPermissionTree($staff->permissions);

        return $this->respond($grantPermissionTree);
    }

    /**
     * @param Staff $staff
     *
     * @return StaffResource
     */
    public function update(Staff $staff)
    {
        $permissionIds = (array)request('permissionIds', []);

        $staff->syncPermissions($permissionIds);

        return new StaffResource($staff);
    }

}