<?php

namespace Kiyon\Laravel\Authorization\Traits;

use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Support\Constant;

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
        return $this->belongsToMany(Role::class, 'sys_role_user', 'user_id');
    }

    /**
     * Many-to-Many relations with organization model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'sys_organization_user', 'user_id');
    }

    /**
     * Many-to-Many relations with permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'sys_permission_user', 'user_id');
    }

    /**
     * 判断用户是否会员
     *
     * @return bool
     */
    public function isMember()
    {
        return $this->roles->where('key', Constant::ROLE_MEMBER)->count() > 0;
    }

    /**
     * 用户是否员工
     *
     * @return bool
     */
    public function isStaff()
    {
        return $this->roles->where('key', Constant::ROLE_STAFF)->count() > 0;
    }

    /**
     * 用户是否系统管理员
     *
     * @return bool
     */
    public function isSystemAdmin()
    {
        return $this->roles->where('key', Constant::ROLE_SYSTEM_ADMIN)->count() > 0;
    }

    /**
     * Boot the user model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the user model uses soft deletes.
     *
     * @return void|bool
     */
    protected static function boot()
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
