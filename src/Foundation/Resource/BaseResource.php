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
     * The collection array count that should be applied.
     *
     * @var int
     */
    public static $count = 0;

    /**
     * @param mixed $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        static::$count = $resource->count();

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
        if (static::$count == 0) {
            return $this->itemArray($request);
        } else {
            static::$count--;
            return $this->collectionArray($request);
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