<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/10
 * Time: 8:29 AM
 */

namespace Kiyon\Laravel\Authentication\Contracts;


use Kiyon\Laravel\Authentication\Model\User;

interface UserRepositoryContract
{

    /**
     * 获取用户的所有权限
     * 自身的，角色的，组织的
     *
     * @param User $user
     * @return \Illuminate\Support\Collection|mixed
     */
    public function getAllPermissions(User $user);
}