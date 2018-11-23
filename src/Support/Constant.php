<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 8:36 PM
 */

namespace Kiyon\Laravel\Support;


class Constant
{

    const PERMISSION_ROOT_ID = 0;

    const SYSTEM_PERMISSION_DESTROY = 'destroy';

    const ROLE_MEMBER = 'member';
    const ROLE_STAFF = 'staff';
    const ROLE_SYSTEM_ADMIN = 'system_admin';

    // 初始化就有的角色
    const INIT_ROLES = [
        self::ROLE_SYSTEM_ADMIN,
        self::ROLE_MEMBER,
        self::ROLE_STAFF
    ];

    const MENU_ROOT_ID = 0;

    const MENU_SIDE_NAV = 'side_nav';
    const MENU_TOP_NAV = 'top_nav';

    const MENU_TYPE = [
        self::MENU_SIDE_NAV,
        self::MENU_TOP_NAV
    ];
}