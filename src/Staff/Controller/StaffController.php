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

class StaffController extends Controller
{

    /** @var StaffService */
    protected $service;

    public function __construct(StaffService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $staffs = $this->service->repo->all();

        return StaffResource::collection($staffs);
    }

    /**
     * @param StaffRequest $request
     * @return StaffResource
     */
    public function store(StaffRequest $request)
    {
        $data = request()->all();

        $staff = $this->service->repo->create($data);

        return new StaffResource($staff);
    }

    /**
     * @param Staff $staff
     * @return StaffResource
     */
    public function show(Staff $staff)
    {
        $staff = $this->service->repo->show($staff);

        return new StaffResource($staff);
    }

    /**
     * @param Staff $staff
     * @param StaffRequest $request
     * @return StaffResource
     */
    public function update(Staff $staff, StaffRequest $request)
    {
        $data = request()->all();

        $staff = $this->service->repo->update($staff, $data);

        return new StaffResource($staff);
    }

    /**
     * @param Staff $staff
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Staff $staff)
    {
        if ($staff->isSystemAdmin()) {
            return $this->respondForbidden();
        }

        $data = request()->all();

        $this->service->repo->destroy($staff, $data);

        return $this->respondNoContent();
    }
}