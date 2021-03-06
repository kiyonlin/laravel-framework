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
use Kiyon\Laravel\Foundation\Routing\Controller;

class OrganizationUserController extends Controller
{

    /** @var OrganizationService */
    protected $service;

    public function __construct(OrganizationService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Organization $organization
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Organization $organization)
    {
        $userIds = (array)request('userIds', []);

        $organization->attachUsers($userIds);

        return $this->respond();
    }
}