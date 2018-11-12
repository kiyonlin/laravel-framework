<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 10:05 AM
 */

namespace Kiyon\Laravel\Authentication\Service;

use Kiyon\Laravel\Authentication\Contracts\UserRepositoryContract;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Support\Constant;

class UserService
{

    /**
     * @var User
     */
    protected $model;

    /**
     * @var UserRepositoryContract
     */
    protected $repo;

    public function __construct(User $model, UserRepositoryContract $repo)
    {
        $this->model = $model;
        $this->repo = $repo;
    }

    /**
     * 获取用户所有的能力
     *
     * @param User $user
     * @return array
     */
    public function getAllAbilities(User $user)
    {
        $permissions = $this->repo->getAllPermissions($user);

        return $permissions->sortBy('id')->pluck('ability')->toArray();
    }

    /**
     * 判断用户是否有能力
     *
     * @param User $user
     * @param array|string $abilities
     * @return bool
     */
    public function can(User $user, $abilities)
    {
        $roles = $user->roles->pluck('key')->toArray();
        if (in_array(Constant::ROLE_SYSTEM_ADMIN, $roles)) {
            return true;
        }

        $ownAbilities = $this->getAllAbilities($user);

        foreach ((array) $abilities as $ability) {
            if (! in_array($ability, $ownAbilities)) {
                return false;
            }
        }

        return true;
    }
}