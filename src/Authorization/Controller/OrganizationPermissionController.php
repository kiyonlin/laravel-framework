<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:33 PM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Service\OrganizationService;
use Kiyon\Laravel\Authorization\Service\PermissionService;
use Kiyon\Laravel\Foundation\Routing\Controller;

class OrganizationPermissionController extends Controller
{

    /** @var OrganizationService */
    protected $service;

    /** @var PermissionService */
    protected $permissionService;

    public function __construct(OrganizationService $service, PermissionService $permissionService)
    {
        $this->service = $service;
        $this->permissionService = $permissionService;
    }

    /**
     * @param Organization $organization
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Organization $organization)
    {
        $nodes = $this->permissionService->getNgZorroPermissionTree();

        $defaultChecked = $organization->permissions->pluck('id')->toArray();

        return $this->respond(compact('defaultChecked', 'nodes'));
    }

    /**
     * @param Organization $organization
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Organization $organization)
    {
        $permissionIds = (array)request('permissionIds', []);

        $organization->syncPermissions($permissionIds);

        return $this->respond();
    }
}