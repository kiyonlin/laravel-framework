<?php

namespace Kiyon\Laravel\Menu\Repository;

use Kiyon\Laravel\Foundation\Repository\RestfulRepository;
use Kiyon\Laravel\Menu\Model\Menu;
use Kiyon\Laravel\Menu\Contracts\MenuRepositoryContract;

class MenuRepository implements MenuRepositoryContract
{

    use RestfulRepository;

    /** @var Menu */
    protected $model;

    /**
     * MenuRepository constructor.
     * @param Menu $model
     */
    public function __construct(Menu $model)
    {
        $this->model = $model;
    }
}
