<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/24
 * Time: 9:47 PM
 */

namespace Kiyon\Laravel\Menu\Resource;

use Kiyon\Laravel\Foundation\Resource\BaseResource;

class MenuResource extends BaseResource
{

    /**
     * {@inheritdoc}
     */
    public function itemArray($request)
    {
        return parent::itemArray($request);
    }

    /**
     * {@inheritdoc}
     */
    public function collectionArray($request)
    {
        return [
            'id'           => $this->id,
            'parent_menu'  => $this->parentMenu,
            'key'          => $this->key,
            'display_name' => $this->display_name,
            'type'         => $this->type,
            'link'         => $this->link,
            'icon'         => $this->icon,
        ];
    }
}