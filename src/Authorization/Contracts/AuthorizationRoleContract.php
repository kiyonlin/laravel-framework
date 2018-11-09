<?php

namespace Kiyon\Laravel\Authorization\Contracts;

interface AuthorizationRoleContract extends GrantPermissionContract
{

    /**
     * Many-to-Many relations with the user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users();

    /**
     * Many-to-Many relations with the organization model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations();

}
