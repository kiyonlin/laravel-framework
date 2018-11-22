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
use Kiyon\Laravel\Staff\Service\StaffService;

class StaffController extends Controller
{

    /** @var StaffService */
    protected $service;

    public function __construct(StaffService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $staffs = $this->service->repo->all();

        return $this->respond($staffs);
    }

    /**
     * @param StaffRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StaffRequest $request)
    {
        $data = request()->all();

        $staff = $this->service->repo->create($data);

        return $this->respondCreated($staff->load('roles'));
    }

    /**
     * @param Staff $staff
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Staff $staff)
    {
        $staff = $this->service->repo->edit($staff);

        return $this->respond($staff);
    }

    /**
     * @param Staff $staff
     * @param StaffRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Staff $staff, StaffRequest $request)
    {
        $data = request()->all();

        $staff = $this->service->repo->update($staff, $data);

        return $this->respond($staff);
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