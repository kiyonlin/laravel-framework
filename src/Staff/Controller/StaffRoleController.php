<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 9:19 AM
 */

namespace Kiyon\Laravel\Staff\Controller;


use Kiyon\Laravel\Authorization\Service\RoleService;
use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Staff\Resource\StaffResource;

class StaffRoleController extends Controller
{
    /** @var RoleService */
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @param Staff $staff
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Staff $staff)
    {
        $roles = $this->roleService->all()->map(modelFieldsOnly(['id', 'display_name']));

        $owns = $staff->roles->map(modelFieldsOnly(['id', 'display_name']));

        return $this->respond(compact('roles', 'owns'));
    }

    /**
     * @param Staff $staff
     *
     * @return StaffResource
     */
    public function update(Staff $staff)
    {
        $roleIds = (array)request('roleIds', []);

        $staff->syncRolesWithoutDetaching($roleIds);

        return new StaffResource($staff);
    }

    /**
     * @param Staff $staff
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Staff $staff)
    {
        $roleIds = (array)request('roleIds', []);

        $staff->detachRoles($roleIds);

        return $this->respondNoContent();
    }
}