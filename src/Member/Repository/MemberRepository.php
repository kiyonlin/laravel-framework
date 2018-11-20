<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:40 AM
 */

namespace Kiyon\Laravel\Member\Repository;

use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Foundation\Repository\RestfulRepository;
use Kiyon\Laravel\Member\Contracts\MemberRepositoryContract;
use Kiyon\Laravel\Member\Model\Member;

class MemberRepository implements MemberRepositoryContract
{

    use RestfulRepository;

    /** @var Member */
    protected $model;

    /**
     * MemberRepository constructor.
     * @param Member $model
     */
    public function __construct(Member $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $item
     * @return mixed
     */
    public function create(array $item)
    {
        $member = $this->model->create($item);

        $member->syncRoles(Role::memberRole());

        return $member->load('roles:id,key,display_name');
    }
}