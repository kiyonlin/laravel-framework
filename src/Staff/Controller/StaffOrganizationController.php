<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 9:19 AM
 */

namespace Kiyon\Laravel\Staff\Controller;


use Kiyon\Laravel\Authorization\Service\OrganizationService;
use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Staff\Resource\StaffResource;

class StaffOrganizationController extends Controller
{
    /** @var OrganizationService */
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * @param Staff $staff
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Staff $staff)
    {
        $organizations = $this->organizationService->all()->map(modelFieldsOnly(['id', 'display_name']));

        $owns = $staff->organizations->map(modelFieldsOnly(['id', 'display_name']));

        return $this->respond(compact('organizations', 'owns'));
    }

    /**
     * @param Staff $staff
     *
     * @return StaffResource
     */
    public function update(Staff $staff)
    {
        $organizationIds = (array)request('organizationIds', []);

        $staff->syncOrganizationsWithoutDetaching($organizationIds);

        return new StaffResource($staff);
    }

    /**
     * @param Staff $staff
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Staff $staff)
    {
        $organizationIds = (array)request('organizationIds', []);

        $staff->detachOrganizations($organizationIds);

        return $this->respondNoContent();
    }
}