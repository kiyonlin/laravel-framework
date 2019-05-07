<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/24
 * Time: 9:47 PM
 */

namespace Kiyon\Laravel\Staff\Resource;

use Kiyon\Laravel\Foundation\Resource\BaseResource;

class StaffResource extends BaseResource
{

    /**
     * {@inheritdoc}
     */
    public function itemArray($request)
    {
        return $this->collectionArray($request);
    }

    /**
     * {@inheritdoc}
     */
    public function collectionArray($request)
    {
        return [
            'username'     => $this->username,
            'display_name' => $this->display_name,
            'mobile'       => $this->mobile,
            'email'        => $this->email,
            'locked'       => $this->locked,
            'roles'        => $this->roles->toArray()
        ];
    }
}