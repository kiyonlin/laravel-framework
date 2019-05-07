<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 9:19 AM
 */

namespace Kiyon\Laravel\Staff\Controller;


use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Staff\Request\StaffRequest;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Staff\Resource\StaffResource;
use Kiyon\Laravel\Staff\Service\StaffService;

class StaffGrantController extends Controller
{

    /** @var StaffService */
    protected $service;

    public function __construct(StaffService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Staff $staff
     *
     * @return StaffResource
     */
    public function role(Staff $staff)
    {
        $roleIds = (array)request('roleIds', []);

        $staff->syncRoles($roleIds);

        return new StaffResource($staff);
    }

    /**
     * @param Staff $staff
     *
     * @return StaffResource
     */
    public function permission(Staff $staff)
    {
        $permissionIds = (array)request('permissionIds', []);

        $staff->syncPermissions($permissionIds);

        return new StaffResource($staff);
    }

    /**
     * @param Staff $staff
     *
     * @return StaffResource
     */
    public function organization(Staff $staff)
    {
        $organizationIds = (array)request('organizationIds', []);

        $staff->syncOrganizations($organizationIds);

        return new StaffResource($staff);
    }
}