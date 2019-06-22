<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 3:11 PM
 */

namespace Kiyon\Laravel\Authorization\Model;


use Kiyon\Laravel\Authorization\Contracts\AuthorizationOrganizationContract;
use Kiyon\Laravel\Authorization\Traits\AuthorizableOrganization;
use Kiyon\Laravel\Foundation\Model\BaseModel;

class Organization extends BaseModel implements AuthorizationOrganizationContract
{

    use AuthorizableOrganization;
    use \Kiyon\Laravel\Foundation\Model\Relations\Hierarchy;

    protected $table = 'sys_organizations';

    protected $fillable = [
        'parent_id', 'key', 'display_name', 'description', 'sort'
    ];

    protected $searchable = [
        'key', 'display_name', 'description'
    ];

}