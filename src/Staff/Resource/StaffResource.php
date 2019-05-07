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
        return array_merge(
            $this->collectionArray($request),
            [
                'permissions'   => $this->permissions,
                'organizations' => $this->organizations,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function collectionArray($request)
    {
        return [
            'id'           => $this->id,
            'username'     => $this->username,
            'display_name' => $this->display_name,
            'mobile'       => $this->mobile,
            'email'        => $this->email,
            'locked'       => $this->locked,
            'roles'        => $this->roles,
        ];
    }
}