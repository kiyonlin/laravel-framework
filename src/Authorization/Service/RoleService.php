<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Authorization\Service;


use Kiyon\Laravel\Authorization\Contracts\RoleRepositoryContract;
use Kiyon\Laravel\Foundation\Service\RestfulService;

class RoleService
{

    use RestfulService;

    /** @var RoleRepositoryContract $repo */
    protected $repo;

    public function __construct(RoleRepositoryContract $repo)
    {
        $this->repo = $repo;
    }
}