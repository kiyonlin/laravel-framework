<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:33 AM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Resource\PermissionResource;
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
        $permissions = $this->service->all();

        return $this->respond($permissions);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->all();

        $permission = $this->service->create($data);

        return $this->respondCreated($permission);
    }

    /**
     * @param Permission $permission
     *
     * @return PermissionResource
     */
    public function show(Permission $permission)
    {
        $permission = $this->service->show($permission);

        return new PermissionResource($permission);
    }

    /**
     * @param Permission $permission
     *
     * @return PermissionResource
     */
    public function update(Permission $permission)
    {
        $data = request()->all();

        $permission = $this->service->update($permission, $data);

        return new PermissionResource($permission);
    }

    /**
     * @param Permission $permission
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $data = request()->all();

        $this->service->destroy($permission, $data);

        return $this->respondNoContent();
    }
}