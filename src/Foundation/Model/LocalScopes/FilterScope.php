<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 2:34 PM
 */

namespace Kiyon\Laravel\Foundation\Model\LocalScopes;


use Kiyon\Laravel\Foundation\Model\QueryBuilder;

trait FilterScope
{

    /**
     * auto apply filters to query based on model fields like
     * searchable, sortable, loadable, selectable
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query)
    {
        return QueryBuilder::for($query)
            ->allowedFilters($this->getSearchable())
            ->defaultSort($query->getModel()->getKeyName())
            ->allowedSorts($this->getSortable())
            ->allowedIncludes($this->getLoadable())
            ->allowedFields($this->getSelectable());
    }

    /**
     * get searchable fields
     *
     * @return array
     */
    protected function getSearchable()
    {
        return $this->searchable ?: [];
    }

    /**
     * get sortable fields
     *
     * @return array
     */
    protected function getSortable()
    {
        return $this->sortable ?: [];
    }

    /**
     * get loadable fields
     *
     * @return array
     */
    protected function getLoadable()
    {
        return $this->loadable ?: [];
    }

    /**
     * get selectable fields
     *
     * @return array
     */
    protected function getSelectable()
    {
        return $this->selectable ?: [];
    }
}