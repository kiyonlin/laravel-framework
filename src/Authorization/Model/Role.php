<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 3:10 PM
 */

namespace Kiyon\Laravel\Authorization\Model;


use Kiyon\Laravel\Authorization\Contracts\AuthorizationRoleContract;
use Kiyon\Laravel\Authorization\Traits\AuthorizableRole;
use Kiyon\Laravel\Foundation\Model\BaseModel;

class Role extends BaseModel implements AuthorizationRoleContract
{

    use AuthorizableRole;

    protected $table = 'sys_roles';

    protected $fillable = [
        'key', 'display_name', 'description',
    ];
}