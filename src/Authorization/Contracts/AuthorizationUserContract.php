<?php

namespace Kiyon\Laravel\Authorization\Contracts;

interface AuthorizationUserContract extends GrantOrganizationContract, GrantRoleContract, GrantPermissionContract
{

    /**
     * Check if user has a permission by its name.
     *
     * @param string|array $permission Permission string or array of permissions.
     * @param bool $requireAll All permissions in the array are required.
     *
     * @return bool
     */
    public function can($permission, $requireAll = false);
}
