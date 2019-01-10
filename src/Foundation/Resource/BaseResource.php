<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/25
 * Time: 1:38 PM
 */

namespace Kiyon\Laravel\Foundation\Resource;


use Illuminate\Http\Resources\Json\Resource;

class BaseResource extends Resource
{

    /**
     * The collection array that should be applied.
     *
     * @var boolean
     */
    public static $collection = false;

    /**
     * @param mixed $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        static::$collection = true;

        return parent::collection($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (static::$collection) {
            return tap($this->collectionArray($request), function () {
                static::$collection = false;
            });
        } else {
            return $this->itemArray($request);
        }
    }

    /**
     * array format for collection
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|mixed
     */
    public function collectionArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * array format for single item
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|mixed
     */
    public function itemArray($request)
    {
        return parent::toArray($request);
    }
}