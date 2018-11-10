<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 8:25 AM
 */

namespace Kiyon\Laravel\Authentication\Repository;


use Kiyon\Laravel\Authentication\Contracts\UserRepositoryContract;
use Kiyon\Laravel\Authentication\Model\User;

class UserRepository implements UserRepositoryContract
{

    /**
     * @var User
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllPermissions(User $user)
    {
        $permissions = $user->permissions ?: collect([]);

        $existIds = $permissions->pluck('id')->toArray();

        foreach ($user->roles as $role) {
            $permissions = $permissions->merge($role->permissions()->whereNotIn('id', $existIds)->get());
            $existIds = $permissions->pluck('id')->toArray();
        }

        foreach ($user->organizations as $organization) {
            $permissions = $permissions->merge($organization->permissions()->whereNotIn('id', $existIds)->get());
            $existIds = $permissions->pluck('id')->toArray();

            foreach ($organization->roles as $role) {
                $permissions = $permissions->merge($role->permissions()->whereNotIn('id', $existIds)->get());
                $existIds = $permissions->pluck('id')->toArray();
            }
        }

        return $permissions;
    }
}