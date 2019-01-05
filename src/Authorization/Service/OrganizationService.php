<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 11:17 PM
 */

namespace Kiyon\Laravel\Authorization\Service;


use Kiyon\Laravel\Authorization\Contracts\OrganizationRepositoryContract;
use Kiyon\Laravel\Foundation\Service\RestfulService;

class OrganizationService
{

    use RestfulService;

    /** @var OrganizationRepositoryContract $repo */
    protected $repo;

    public function __construct(OrganizationRepositoryContract $repo)
    {
        $this->repo = $repo;
    }
}