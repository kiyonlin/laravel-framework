<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:33 AM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Service\PermissionService;
use Kiyon\Laravel\Foundation\Routing\Controller;

class PermissionController extends Controller
{

    /** @var PermissionService */
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $permissions = $this->service->repo->all();

        return $this->respond($permissions);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->all();

        $permission = $this->service->repo->create($data);

        return $this->respondCreated($permission);
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Permission $permission)
    {
        $permission = $this->service->repo->edit($permission);

        return $this->respond($permission);
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Permission $permission)
    {
        $data = request()->all();

        $permission = $this->service->repo->update($permission, $data);

        return $this->respond($permission);
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $data = request()->all();

        $this->service->repo->destroy($permission, $data);

        return $this->respondNoContent();
    }
}