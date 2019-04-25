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
use Kiyon\Laravel\Support\Constant;

class Role extends BaseModel implements AuthorizationRoleContract
{

    use AuthorizableRole;

    protected $table = 'sys_roles';

    protected $fillable = [
        'key', 'display_name', 'description',
    ];

    protected $searchable = [
        'key', 'display_name', 'description'
    ];

    /**
     * 获取管理员角色
     *
     * @return mixed
     */
    public static function systemAdminRole()
    {
        return self::where('key', Constant::ROLE_SYSTEM_ADMIN)->first();
    }

    /**
     * 获取会员角色
     *
     * @return mixed
     */
    public static function memberRole()
    {
        return self::where('key', Constant::ROLE_MEMBER)->first();
    }

    /**
     * 获取员工角色
     *
     * @return mixed
     */
    public static function staffRole()
    {
        return self::where('key', Constant::ROLE_STAFF)->first();
    }
}