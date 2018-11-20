<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:40 AM
 */

namespace Kiyon\Laravel\Staff\Repository;

use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Foundation\Repository\RestfulRepository;
use Kiyon\Laravel\Staff\Contracts\StaffRepositoryContract;
use Kiyon\Laravel\Staff\Model\Staff;

class StaffRepository implements StaffRepositoryContract
{

    use RestfulRepository;

    /** @var Staff */
    protected $model;

    /**
     * StaffRepository constructor.
     * @param Staff $model
     */
    public function __construct(Staff $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $item
     * @return mixed
     */
    public function create(array $item)
    {
        $staff = $this->model->create($item);

        $staff->syncRoles(Role::staffRole());

        return $staff->load('roles:id,key,display_name');
    }
}