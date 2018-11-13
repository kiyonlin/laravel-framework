<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/13
 * Time: 1:14 PM
 */

namespace Kiyon\Laravel\Foundation\Model\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class OperatorFilter implements Filter
{

    /**
     * @param Builder $query
     * @param $value
     * @param \Spatie\QueryBuilder\Filters\string $property
     * @return Builder
     */
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        list($filed, $operator) = explode('$', $property);
        // dd($filed, $operator, $value);
        switch (strtolower($operator)) {
            case '><':
                return $query->whereBetween("{$filed}", $value);
            case'!><':
                return $query->whereNotBetween("{$filed}", $value);
            default:
                return $query->where("{$filed}", "{$operator}", $value);
        }
    }
}