<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/19
 * Time: 9:33 PM
 */

namespace Kiyon\Laravel\Authorization\Controller;


use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Authorization\Resource\RoleResource;
use Kiyon\Laravel\Authorization\Service\RoleService;
use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Support\Constant;

class RoleController extends Controller
{

    /** @var RoleService */
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $roles = $this->service->all();

        return $this->respond($roles);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data = request()->all();

        $role = $this->service->create($data);

        return $this->respondCreated($role);
    }

    /**
     * @param Role $role
     *
     * @return RoleResource
     */
    public function show(Role $role)
    {
        $role = $this->service->show($role);

        return new RoleResource($role);
    }

    /**
     * @param Role $role
     *
     * @return RoleResource | \Illuminate\Http\JsonResponse
     */
    public function update(Role $role)
    {
        $data = request()->all();

        if (array_has($data, 'key')
            && array_get($data, 'key') != $role->key
            && in_array($role->key, Constant::INIT_ROLES)) {
            return $this->respondForbidden();
        }

        $role = $this->service->update($role, $data);

        return new RoleResource($role);
    }

    /**
     * @param Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if (in_array($role->key, Constant::INIT_ROLES)) {
            return $this->respondForbidden();
        }

        $data = request()->all();

        $this->service->destroy($role, $data);

        return $this->respondNoContent();
    }
}