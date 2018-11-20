<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/20
 * Time: 8:43 AM
 */

namespace Tests\Unit\GlobalScopes;


use Kiyon\Laravel\Member\Model\Member;
use Kiyon\Laravel\Staff\Model\Staff;
use Tests\TestCase;

class UserTypeScopeTest extends TestCase
{

    /** @test */
    public function 使用Member模型时，附加是否member角色查询()
    {
        $sql = Member::where('created_at', '>', now())->toSql();

        $expectedSql = 'select * from "sys_users" where "created_at" > ? and exists (select * from "sys_roles" inner join "sys_role_user" on "sys_roles"."id" = "sys_role_user"."role_id" where "sys_users"."id" = "sys_role_user"."user_id" and "key" = ?)';

        $this->assertEquals($expectedSql, $sql);
    }

    /** @test */
    public function 使用Staff模型时，附加是否staff角色查询()
    {
        $sql = Staff::where('created_at', '>', now())->toSql();

        $expectedSql = 'select * from "sys_users" where "created_at" > ? and exists (select * from "sys_roles" inner join "sys_role_user" on "sys_roles"."id" = "sys_role_user"."role_id" where "sys_users"."id" = "sys_role_user"."user_id" and "key" = ?)';

        $this->assertEquals($expectedSql, $sql);
    }
}