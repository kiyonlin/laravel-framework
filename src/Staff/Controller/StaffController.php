<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 9:19 AM
 */

namespace Kiyon\Laravel\Staff\Controller;


use Illuminate\Database\Eloquent\Builder;
use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Staff\Service\StaffService;
use Kiyon\Laravel\Support\Constant;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Staff $staff)
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