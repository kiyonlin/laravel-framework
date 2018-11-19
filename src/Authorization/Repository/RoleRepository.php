<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:40 AM
 */

namespace Kiyon\Laravel\Authorization\Repository;

use Kiyon\Laravel\Authorization\Contracts\RoleRepositoryContract;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Foundation\Repository\RestfulRepository;

class RoleRepository implements RoleRepositoryContract
{

    use RestfulRepository;

    /** @var Role */
    protected $model;

    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}