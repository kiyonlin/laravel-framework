<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 2:58 PM
 */

namespace Kiyon\Laravel\Foundation\Model;


use Illuminate\Database\Eloquent\Model;
use Kiyon\Laravel\Foundation\Model\GlobalScopes\MemberScope;
use Kiyon\Laravel\Foundation\Model\LocalScopes\FilterScope;

class BaseModel extends Model
{

    use FilterScope;

    /**
     * The fields or relation fields to be filtered on every query filter.
     *
     * @var array
     */
    protected $searchable = [];

    /**
     * The fields to be sorted on every query filter.
     *
     * @var array
     */
    protected $sortable = [];

    /**
     * The relations to eager load on every query filter.
     *
     * @var array
     */
    protected $loadable = [];

    /**
     * The fields to be selected on every query filter.
     *
     * @var array
     */
    protected $selectable = [];

    /**
     * 模型的「启动」方法
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MemberScope);
    }
}