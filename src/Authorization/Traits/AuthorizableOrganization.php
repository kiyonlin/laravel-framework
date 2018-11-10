<?php

namespace Kiyon\Laravel\Authorization\Traits;

use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;

trait AuthorizableOrganization
{

    use GrantPermission, GrantRole, GrantUser;

    /**
     * Many-to-Many relations with the user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'sys_organization_user');
    }

    /**
     * Many-to-Many relations with the user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'sys_organization_role');
    }

    /**
     * Many-to-Many relations with the permission model.
     * Named "perms" for backwards compatibility. Also because "perms" is short and sweet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'sys_organization_permission');
    }

    /**
     * Boot the organization model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the organization model uses soft deletes.
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function (Organization $organization) {
            if (! method_exists(Organization::class, 'bootSoftDeletingTrait')) {
                $organization->users()->detach();
                $organization->roles()->detach();
                $organization->permissions()->detach();
            }

            return true;
        });
    }
}
