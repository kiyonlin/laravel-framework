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
use Kiyon\Laravel\Support\Model\BaseModel;

class Organization extends BaseModel implements AuthorizationOrganizationContract
{

    use AuthorizableOrganization;

    protected $table = 'sys_organizations';

    protected $fillable = [
        'key', 'display_name', 'description',
    ];
}