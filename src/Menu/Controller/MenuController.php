<?php

namespace Kiyon\Laravel\Menu\Controller;

use Kiyon\Laravel\Foundation\Routing\Controller;
use Kiyon\Laravel\Menu\Model\Menu;
use Kiyon\Laravel\Menu\Request\MenuRequest;
use Kiyon\Laravel\Menu\Service\MenuService;
use Kiyon\Laravel\Menu\Resource\MenuResource;

class MenuController extends Controller
{
    /** @var MenuService */
    protected $service;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $menus = $this->service->all();

        return MenuResource::collection($menus);
    }

    /**
     * @param MenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MenuRequest $request)
    {
        $data = request()->all();

        $menu = $this->service->create($data);

        return $this->respondCreated($menu);
    }

    /**
     * @param Menu $menu
     * @return MenuResource
     */
    public function show(Menu $menu)
    {
        $menu = $this->service->show($menu);

        return new MenuResource($menu);
    }

    /**
     * @param Menu        $menu
     * @param MenuRequest $request
     *
     * @return MenuResource
     */
    public function update(Menu $menu, MenuRequest $request)
    {
        $data = request()->all();

        $menu = $this->service->update($menu, $data);

        return new MenuResource($menu);
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $data = request()->all();

        $this->service->destroy($menu, $data);

        return $this->respondNoContent();
    }
}
