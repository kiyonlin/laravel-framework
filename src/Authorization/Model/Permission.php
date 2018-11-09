<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/8
 * Time: 3:01 PM
 */

namespace Kiyon\Laravel\Authorization\Model;

use Kiyon\Laravel\Authorization\Contracts\AuthorizationPermissionContract;
use Kiyon\Laravel\Authorization\Traits\AuthorizablePermission;
use Kiyon\Laravel\Support\Model\BaseModel;

class Permission extends BaseModel implements AuthorizationPermissionContract
{

    use AuthorizablePermission;

    protected $table = 'sys_permissions';

    protected $fillable = [
        'parent_id', 'key', 'display_name', 'description', 'level'
    ];

    protected $appends = [
        'ability'
    ];

}