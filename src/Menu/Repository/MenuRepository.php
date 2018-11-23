<?php

namespace Kiyon\Laravel\Menu\Repository;

use Kiyon\Laravel\Foundation\Repository\RestfulRepository;
use Kiyon\Laravel\Menu\Model\Menu;
use Kiyon\Laravel\Menu\Contracts\MenuRepositoryContract;
use Kiyon\Laravel\Support\Constant;

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

    /**
     * {@inheritdoc}
     */
    public function sideNav()
    {
        $builder = $this->model->where('type', Constant::MENU_SIDE_NAV);

        return $this->all($builder);
    }

    /**
     * {@inheritdoc}
     */
    public function topNav()
    {
        $builder = $this->model->where('type', Constant::MENU_TOP_NAV);

        return $this->all($builder);
    }


}
