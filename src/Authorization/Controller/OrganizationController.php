<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:33 AM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Service\OrganizationService;
use Kiyon\Laravel\Foundation\Routing\Controller;

class OrganizationController extends Controller
{

    /** @var OrganizationService */
    protected $service;

    public function __construct(OrganizationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $organizations = $this->service->repo->all();

        return $this->respond($organizations);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->all();

        $organization = $this->service->repo->create($data);

        return $this->respondCreated($organization);
    }

    /**
     * @param Organization $organization
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Organization $organization)
    {
        $organization = $this->service->repo->edit($organization);

        return $this->respond($organization);
    }

    /**
     * @param Organization $organization
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Organization $organization)
    {
        $data = request()->all();

        $organization = $this->service->repo->update($organization, $data);

        return $this->respond($organization);
    }

    /**
     * @param Organization $organization
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Organization $organization)
    {
        $data = request()->all();

        $this->service->repo->destroy($organization, $data);

        return $this->respondNoContent();
    }
}