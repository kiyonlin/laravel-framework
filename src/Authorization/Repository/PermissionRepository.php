<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:40 AM
 */

namespace Kiyon\Laravel\Authorization\Repository;

use Kiyon\Laravel\Authorization\Contracts\PermissionRepositoryContract;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Foundation\Repository\RestfulRepository;

class PermissionRepository implements PermissionRepositoryContract
{

    use RestfulRepository;

    /** @var Permission */
    protected $model;

    /**
     * PermissionRepository constructor.
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
}