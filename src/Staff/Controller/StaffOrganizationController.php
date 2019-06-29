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
        $nodes = $this->organizationService->getNgZorroOrganizationTree();

        $defaultChecked = $staff->organizations->pluck('id')->toArray();

        return $this->respond(compact('defaultChecked', 'nodes'));
    }

    /**
     * @param Staff $staff
     *
     * @return StaffResource
     */
    public function update(Staff $staff)
    {
        $organizationIds = (array)request('organizationIds', []);

        $staff->syncOrganizations($organizationIds);

        return new StaffResource($staff);
    }
}