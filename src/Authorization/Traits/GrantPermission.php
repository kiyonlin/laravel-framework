<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 9:13 AM
 */

namespace Kiyon\Laravel\Authorization\Traits;


use Illuminate\Support\Collection;

trait GrantPermission
{

    /**
     * sync permissions.
     *
     * @param mixed $permissions
     *
     * @return void
     */
    public function syncPermissions($permissions)
    {
        $this->permissions()->sync($permissions);
    }

    /**
     * Attach permission to current user | role | organization.
     *
     * @param array|object|int $permissions
     * @param array            $pivot
     *
     * @return void
     */
    public function attachPermissions($permissions, $pivot = [])
    {
        if ($permissions instanceof Collection) {
            $this->permissions()->attach($permissions);
        } else {
            $this->permissions()->attach($permissions, $pivot);
        }
    }

    /**
     * Detach permission form current user | role | organization.
     *
     * @param object|array|int $permissions
     *
     * @return void
     */
    public function detachPermissions($permissions)
    {
        $this->permissions()->detach($permissions);
    }
}