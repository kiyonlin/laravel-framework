<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/24
 * Time: 9:47 PM
 */

namespace Kiyon\Laravel\Authorization\Resource;

use Kiyon\Laravel\Foundation\Resource\BaseResource;

class OrganizationResource extends BaseResource
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
        return parent::collectionArray($request);
    }
}