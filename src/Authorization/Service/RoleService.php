<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Authorization\Service;


use Kiyon\Laravel\Authorization\Contracts\RoleRepositoryContract;

class RoleService
{

    /** @var RoleRepositoryContract $repo */
    public $repo;

    public function __construct(RoleRepositoryContract $repo)
    {
        $this->repo = $repo;
    }
}