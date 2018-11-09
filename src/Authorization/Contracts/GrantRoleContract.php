<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 10:32 AM
 */

namespace Kiyon\Laravel\Authorization\Contracts;


interface GrantRoleContract
{

    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * sync roles.
     *
     * @param mixed $roles
     * @param array $pivot
     * @return void
     */
    public function syncRoles($roles, $pivot = []);

    /**
     * Attach multiple roles to a user | organization
     *
     * @param mixed $roles
     * @param array $pivot
     * @return
     */
    public function attachRoles($roles, $pivot = []);

    /**
     * Detach multiple roles from a user | organization
     *
     * @param mixed $roles
     */
    public function detachRoles($roles);
}