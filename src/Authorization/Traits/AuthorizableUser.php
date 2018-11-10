<?php

namespace Kiyon\Laravel\Authorization\Traits;

use InvalidArgumentException;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;

trait AuthorizableUser
{

    use GrantPermission, GrantRole, GrantOrganization;

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'sys_role_user');
    }

    /**
     * Many-to-Many relations with organization model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'sys_organization_user');
    }

    /**
     * Many-to-Many relations with permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'sys_permission_user');
    }

    /**
     * Check if user has abilities.
     *
     * @param string|array $abilities ability string or array of abilities.
     * @param bool $requireAll All abilities in the array are required.
     *
     * @return bool
     */
    public function can($abilities, $requireAll = false)
    {
        if (is_array($abilities)) {
            foreach ($abilities as $permName) {
                $hasPerm = $this->can($permName);

                if ($hasPerm && ! $requireAll) {
                    return true;
                } elseif (! $hasPerm && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                // Validate against the Permission table
                foreach ($role->perms as $perm) {
                    if ($perm->name == $abilities) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Boot the user model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the user model uses soft deletes.
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function (User $user) {
            if (! method_exists(User::class, 'bootSoftDeletingTrait')) {
                $user->roles()->detach();
                $user->organizations()->detach();
                $user->permissions()->detach();
            }

            return true;
        });
    }

}
