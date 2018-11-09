<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 9:15 AM
 */

namespace Kiyon\Laravel\Authorization\Traits;


use Illuminate\Support\Collection;

trait GrantRole
{

    /**
     * sync roles.
     *
     * @param mixed $roles
     *
     * @param array $pivot
     * @return void
     */
    public function syncRoles($roles, $pivot = [])
    {
        if ($roles instanceof Collection) {
            $this->roles()->sync($roles);
        } else {
            $this->roles()->sync($roles, $pivot);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $roles
     * @param array $pivot
     * @return void
     */
    public function attachRoles($roles, $pivot = [])
    {
        if ($roles instanceof Collection) {
            $this->roles()->attach($roles);
        } else {
            $this->roles()->attach($roles, $pivot);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $roles
     */
    public function detachRoles($roles)
    {
        $this->roles()->detach($roles);
    }
}