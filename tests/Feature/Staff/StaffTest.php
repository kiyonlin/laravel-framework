<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/12
 * Time: 9:23 AM
 */

namespace Tests\Feature\Staff;


use Kiyon\Laravel\Staff\Model\Staff;
use Kiyon\Laravel\Support\Constant;
use Symfony\Component\HttpFoundation\Response;
use Tests\AuthTestCase;

class StaffTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不能查看员工列表()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.staff.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看员工列表()
    {
        $this->signInSystemAdmin();

        createStaff(5);

        $resp = $this->getJson(route('system.staff.index'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        // 两个系统管理员
        $this->assertCount(5 + 2, $resp);
    }

    /** @test */
    public function 未授权用户不能添加员工()
    {
        $this->withExceptionHandling();

        $staff = raw(Staff::class);

        $this->postJson(route('system.staff.store'), $staff)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以添加员工()
    {
        $this->signInSystemAdmin();

        $staff = raw(Staff::class);

        $resp = $this->postJson(route('system.staff.store'), $staff)
            ->assertStatus(Response::HTTP_CREATED)
            ->json();

        $this->assertEquals($staff['email'], array_get($resp, 'email'));
        $this->assertEquals(Constant::ROLE_STAFF, array_get($resp, 'roles.0.key'));
    }

    /** @test */
    public function 员工表单不合法时无法添加()
    {
        $this->withExceptionHandling();

        $this->assertErrorsHas($this->storeStaff(['mobile' => null]), 'mobile');
        $this->assertErrorsHas($this->storeStaff(['mobile' => '13675822217']), 'mobile');

        $this->assertErrorsHas($this->storeStaff(['password' => null]), 'password');
        $this->assertErrorsHas($this->storeStaff(['password' => str_random(51)]), 'password');

        $this->assertErrorsHas($this->storeStaff(['display_name' => str_random(51)]), 'display_name');

        $this->assertErrorsHas($this->storeStaff(['email' => str_random(11)]), 'email');
        $this->assertErrorsHas($this->storeStaff(['email' => 'kiyonlin@163.com']), 'email');
    }

    /** @test */
    public function 未授权用户不能删除员工()
    {
        $this->withExceptionHandling();

        $staff = createStaff();

        $this->deleteJson(route('system.staff.destroy', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以删除员工()
    {
        $this->signInSystemAdmin();

        $staff = createStaff();

        $this->deleteJson(route('system.staff.destroy', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing($staff->getTable(), ['id' => $staff->id]);
    }


    /** @test */
    public function 未授权用户不能查看员工()
    {
        $this->withExceptionHandling();

        $staff = createStaff();

        $this->getJson(route('system.staff.show', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看员工()
    {
        $this->signInSystemAdmin();

        $staff = createStaff();

        $resp = $this->getJson(route('system.staff.show', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertEquals($staff['email'], array_get($resp, 'email'));
        $this->assertEquals(Constant::ROLE_STAFF, array_get($resp, 'roles.0.key'));
    }

    /** @test */
    public function 未授权用户不能更新员工()
    {
        $this->withExceptionHandling();

        $staff = createStaff();

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.staff.update', ['staff' => $staff->id]), $update)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以更新员工()
    {
        $this->signInSystemAdmin();

        $staff = createStaff();

        $update = ['display_name' => 'updated_display_name'];

        $this->patchJson(route('system.staff.update', ['staff' => $staff->id]), $update)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas($staff->getTable(), array_merge(['id' => $staff->id], $update));
    }

    /** @test */
    public function 员工表单不合法时无法更新()
    {
        $this->withExceptionHandling();

        $this->assertErrorsHas($this->updateStaff(['mobile' => null]), 'mobile');
        $this->assertErrorsHas($this->updateStaff(['mobile' => '13675822217']), 'mobile');

        $this->assertErrorsHas($this->updateStaff(['password' => str_random(51)]), 'password');

        $this->assertErrorsHas($this->updateStaff(['display_name' => str_random(51)]), 'display_name');

        $this->assertErrorsHas($this->updateStaff(['email' => str_random(11)]), 'email');
        $this->assertErrorsHas($this->updateStaff(['email' => 'kiyonlin@163.com']), 'email');
    }

    /** @test */
    public function 授权用户可以批量删除员工()
    {
        $this->signInSystemAdmin();

        $staffs = createStaff(5);

        $this->deleteJson(route('system.staff.destroy', ['staff' => $staffs[0]->id]),
            // 使用字符串参数测试代码
            ['ids' => implode(',', $staffs->pluck('id')->toArray())])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $staffs->each(function ($staff) {
            $this->assertDatabaseMissing($staff->getTable(), ['id' => $staff->id]);
        });
    }

    /** @test */
    public function 系统管理员无法删除()
    {
        $this->signInSystemAdmin();

        $staff = auth()->user();

        $this->deleteJson(route('system.staff.destroy', ['staff' => $staff->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 添加记录辅助函数
     *
     * @param array $override
     *
     * @return array
     */
    protected function storeStaff(array $override = [])
    {
        $this->signInSystemAdmin();

        $staff = raw(Staff::class, $override);

        return $this->postJson(route('system.staff.store'), $staff)
            ->json();
    }

    /**
     * 更新记录辅助函数
     *
     * @param array $update
     *
     * @return array
     */
    protected function updateStaff(array $update)
    {
        $this->signInSystemAdmin();

        $staff = createStaff();

        return $this->patchJson(route('system.staff.update', ['staff' => $staff->id]), $update)
            ->json();
    }
}