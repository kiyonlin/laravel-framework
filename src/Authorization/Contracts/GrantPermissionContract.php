<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 10:32 AM
 */

namespace Kiyon\Laravel\Authorization\Contracts;


interface GrantPermissionContract
{

    /**
     * Many-to-Many relations with the permission model.
     * Named "perms" for backwards compatibility. Also because "perms" is short and sweet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions();

    /**
     * sync permissions.
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function syncPermissions($permissions);


    /**
     * Attach multiple permissions to current role | user | organization.
     *
     * @param mixed $permissions
     *
     * @param array $pivot
     *
     * @return void
     */
    public function attachPermissions($permissions, $pivot = []);

    /**
     * Detach multiple permissions from current role | user | organization
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function detachPermissions($permissions);
}