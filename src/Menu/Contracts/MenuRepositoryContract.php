<?php

namespace Kiyon\Laravel\Menu\Contracts;

use Illuminate\Database\Eloquent\Model;
use Kiyon\Laravel\Contracts\Repository\RestfulRepositoryContract;

interface MenuRepositoryContract extends RestfulRepositoryContract
{

    /**
     * get all side nav menus
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model[]|mixed
     */
    public function sideNav();

    /**
     * get all top nav menus
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model[]|mixed
     */
    public function topNav();
}
