<?php

namespace Kiyon\Laravel\Menu\Controller;

use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Menu\Model\Menu;
use Kiyon\Laravel\Menu\Request\MenuRequest;
use Kiyon\Laravel\Menu\Service\MenuService;

class MenuController extends Controller
{
    /** @var MenuService */
    protected $service;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $menus = $this->service->repo->all();

        return $this->respond($menus);
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuRequest $request)
    {
        $data = request()->all();

        $menu = $this->service->repo->create($data);

        return $this->respondCreated($menu);
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Menu $menu)
    {
        $menu = $this->service->repo->edit($menu);

        return $this->respond($menu);
    }

    /**
     * @param Menu $menu
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Menu $menu, MenuRequest $request)
    {
        $data = request()->all();

        $menu = $this->service->repo->update($menu, $data);

        return $this->respond($menu);
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $data = request()->all();

        $this->service->repo->destroy($menu, $data);

        return $this->respondNoContent();
    }
}
