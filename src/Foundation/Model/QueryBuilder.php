<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 3:40 PM
 */

namespace Kiyon\Laravel\Foundation\Model;


use Kiyon\Laravel\Foundation\Model\Filters\OperatorFilter;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

class QueryBuilder extends SpatieQueryBuilder
{

    public function allowedFilters($filters): parent
    {
        $filters = is_array($filters) ? $filters : func_get_args();

        $this->extension($filters);

        $this->allowedFilters = collect($filters)->map(function ($filter) {
            if ($filter instanceof Filter) {
                return $filter;
            }

            return Filter::partial($filter);
        });

        $this->guardAgainstUnknownFilters();

        $this->addFiltersToQuery($this->request->filters());

        return $this;
    }

    protected function extension(&$filters)
    {
        $this->request->filters()->each(function ($value, $property) use (&$filters) {
            if (str_contains($property, '$')) {
                list($filed, $operator) = explode('$', $property);
                if (in_array($filed, $filters)) {
                    $filters[] = Filter::custom($property, OperatorFilter::class);;
                }
            }
        });
    }
}