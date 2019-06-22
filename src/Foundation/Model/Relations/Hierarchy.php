<?php


namespace Kiyon\Laravel\Foundation\Model\Relations;


trait Hierarchy
{
    /**
     * 子项
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * 父项
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}