<?php

namespace Kiyon\Laravel\Menu;


use Kiyon\Laravel\Foundation\Model\BaseModel;

class Menu extends BaseModel
{

    protected $table = 'sys_menus';

    protected $fillable = [
        'text', 'i18n', 'type', 'group', 'link', 'linkExact', 'externalLink', 'target',
        'icon', 'badge', 'badge_dot', 'badge_status', 'hide', 'hideInBreadcrumb',
        'shortcut', 'shortcut_root', 'parent_id'
    ];

    protected $casts = [
        'parent_id'        => 'integer',
        'group'            => 'boolean',
        'linkExact'        => 'boolean',
        'badge_dot'        => 'boolean',
        'hide'             => 'boolean',
        'hideInBreadcrumb' => 'boolean',
        'shortcut'         => 'boolean',
        'shortcut_root'    => 'boolean',
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
}