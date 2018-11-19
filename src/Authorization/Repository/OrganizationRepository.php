<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:40 AM
 */

namespace Kiyon\Laravel\Authorization\Repository;

use Kiyon\Laravel\Authorization\Contracts\OrganizationRepositoryContract;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Foundation\Repository\RestfulRepository;

class OrganizationRepository implements OrganizationRepositoryContract
{

    use RestfulRepository;

    /** @var Organization */
    protected $model;

    /**
     * OrganizationRepository constructor.
     * @param Organization $model
     */
    public function __construct(Organization $model)
    {
        $this->model = $model;
    }
}