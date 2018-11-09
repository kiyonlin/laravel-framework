<?php

namespace Kiyon\Laravel\Authorization\Traits;

use Illuminate\Database\Eloquent\Model;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Organization;
use Kiyon\Laravel\Authorization\Model\Permission;
use Kiyon\Laravel\Authorization\Model\Role;

trait AuthorizablePermission
{

    /**
     * Many-to-Many relations with user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'sys_permission_user');
    }

    /**
     * Many-to-Many relations with role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'sys_permission_role');
    }

    /**
     * Many-to-Many relations with organization model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'sys_organization_permission');
    }

    /**
     * One-to-Many relations with permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subPermissions()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    /**
     * One-to-Many relations with permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentPermission()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    /**
     * append ability attribute
     * @return string
     */
    public function getAbilityAttribute()
    {
        return $this->getAbility();
    }

    /**
     * 递归获取由key组成的能力
     *
     * @return string
     */
    protected function getAbility()
    {
        if ($this->parentPermission) {
            return $this->parentPermission->ability . '.' . $this->attributes['key'];
        }

        return $this->attributes['key'];
    }

    /**
     * Boot the permission model
     * Attach event listener to remove the many-to-many records when trying to delete
     * Will NOT delete any records if the permission model uses soft deletes.
     *
     * @return void|bool
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function (Model $permission) {
            if (! method_exists(Permission::class, 'bootSoftDeletingTrait')) {
                $permission->users()->detach();
                $permission->roles()->detach();
                $permission->organizations()->detach();
            }

            return true;
        });

        static::saving(function (Model $permission) {
            if ($permission->parent_id && $permission->level == 1) {
                $parentPermission = self::find($permission->parent_id);
                $permission->level = $parentPermission->level + 1;
            }
            if ($permission->parent_id == 0) {
                $permission->level = 1;
            }

            return true;
        });

        static::saved(function (Model $permission) {
            if (array_get($permission->getDirty(), 'parent_id') !== null) {
                self::updateSubPermissions($permission);
            }
        });
    }

    /**
     * 更新子权限层级
     *
     * @param $permission
     */
    protected static function updateSubPermissions(Permission $permission)
    {
        foreach ($permission->refresh()->subPermissions as $subPermission) {
            $subPermission->update([
                'level' => $permission->level + 1
            ]);
            self::updateSubPermissions($subPermission);
        }
    }
}
