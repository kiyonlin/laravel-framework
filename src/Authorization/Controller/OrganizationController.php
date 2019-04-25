<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:33 AM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Resource\OrganizationResource;
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
        $organizations = $this->service->all();

        return $this->respond($organizations);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->all();

        $organization = $this->service->create($data);

        return $this->respondCreated($organization);
    }

    /**
     * @param Organization $organization
     *
     * @return OrganizationResource
     */
    public function show(Organization $organization)
    {
        $organization = $this->service->show($organization);

        return new OrganizationResource($organization);
    }

    /**
     * @param Organization $organization
     *
     * @return OrganizationResource
     */
    public function update(Organization $organization)
    {
        $data = request()->all();

        $organization = $this->service->update($organization, $data);

        return new OrganizationResource($organization);
    }

    /**
     * @param Organization $organization
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Organization $organization)
    {
        $data = request()->all();

        $this->service->destroy($organization, $data);

        return $this->respondNoContent();
    }
}