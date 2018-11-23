<?php

namespace Kiyon\Laravel\Menu\Model;


use Kiyon\Laravel\Foundation\Model\BaseModel;

class Menu extends BaseModel
{

    protected $table = 'sys_menus';

    protected $fillable = [
        'key', 'display_name', 'type', 'group', 'link', 'link_exact', 'external_link', 'target',
        'icon', 'badge', 'badge_dot', 'badge_status', 'hide', 'hide_in_breadcrumb',
        'shortcut', 'shortcut_root', 'parent_id'
    ];

    protected $casts = [
        'parent_id'          => 'integer',
        'group'              => 'boolean',
        'link_exact'         => 'boolean',
        'badge_dot'          => 'boolean',
        'hide'               => 'boolean',
        'hide_in_breadcrumb' => 'boolean',
        'shortcut'           => 'boolean',
        'shortcut_root'      => 'boolean',
    ];

    protected $appends = [
        'uniqueKey'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function parentMenu()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * append uniqueKey attribute
     * @return string
     */
    public function getUniqueKeyAttribute()
    {
        return $this->getUniqueKey();
    }

    /**
     * 递归获取由key组成的UniqueKey
     *
     * @return string
     */
    protected function getUniqueKey()
    {
        if ($this->parentMenu) {
            return $this->parentmenu->uniqueKey . '.' . $this->attributes['key'];
        }

        return $this->attributes['key'];
    }
}