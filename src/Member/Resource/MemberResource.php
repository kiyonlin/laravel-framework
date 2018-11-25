<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/24
 * Time: 9:47 PM
 */

namespace Kiyon\Laravel\Member\Resource;

use Kiyon\Laravel\Foundation\Resource\BaseResource;

class MemberResource extends BaseResource
{

    /**
     * {@inheritdoc}
     */
    public function itemArray($request)
    {
        return [
            'username'     => $this->username,
            'display_name' => $this->display_name,
            'mobile'       => $this->mobile,
            'email'        => $this->email,
            'locked'       => $this->locked,
            'roles'         => $this->roles->toArray()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function collectionArray($request)
    {
        return [
            'display_name' => $this->display_name,
            'mobile'       => $this->mobile,
            'locked'       => $this->locked,
            'roles'         => $this->roles
        ];
    }
}