<?php

namespace Kiyon\Laravel\Authorization\Contracts;

interface AuthorizationUserContract extends GrantOrganizationContract, GrantRoleContract, GrantPermissionContract
{

    /**
     * 判断用户是否会员
     *
     * @return bool
     */
    public function isMember();

    /**
     * 用户是否员工
     *
     * @return bool
     */
    public function isStaff();
}
