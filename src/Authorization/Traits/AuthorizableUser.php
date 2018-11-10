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
