<?php

namespace Kiyon\Laravel\Menu\Test\Feature;

use Symfony\Component\HttpFoundation\Response;
use Kiyon\Laravel\Menu\Model\Menu;
use Tests\AuthTestCase;

class MenuTest extends AuthTestCase
{

    /** @test */
    public function 未授权用户不能查看menu列表()
    {
        $this->withExceptionHandling();

        $this->getJson(route('system.menu.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看menu列表()
    {
        $this->signInSystemAdmin();

        create(Menu::class, 5);

        $resp = $this->getJson(route('system.menu.index'))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $this->assertCount(5, $resp);
    }

    /** @test */
    public function 未授权用户不能添加menu()
    {
        $this->withExceptionHandling();

        $menu = raw(Menu::class);

        $this->postJson(route('system.menu.store'), $menu)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以添加menu()
    {
        $this->signInSystemAdmin();

        $menu = raw(Menu::class);

        $resp = $this->postJson(route('system.menu.store'), $menu)
            ->assertStatus(Response::HTTP_CREATED)
            ->json();

        $this->assertEquals($menu, array_only($resp, array_keys($menu)));
    }

    /** @test */
    public function menu表单不合法时无法添加()
    {
        $this->withExceptionHandling();

        $this->assertErrorsHas($this->storeMenu(['parent_id' => null]), 'parent_id');
        $this->assertErrorsHas($this->storeMenu(['parent_id' => 'not a number']), 'parent_id');
        $this->assertErrorsHas($this->storeMenu(['parent_id' => -1]), 'parent_id');

        $this->assertErrorsHas($this->storeMenu(['display_name' => 123]), 'display_name');
        $this->assertErrorsHas($this->storeMenu(['display_name' => str_random(51)]), 'display_name');

        $this->assertErrorsHas($this->storeMenu(['key' => null]), 'key');
        $this->assertErrorsHas($this->storeMenu(['key' => 'invalid key']), 'key');
        $this->assertErrorsHas($this->storeMenu(['key' => str_random(51)]), 'key');

        $this->assertErrorsHas($this->storeMenu(['type' => null]), 'type');
        $this->assertErrorsHas($this->storeMenu(['type' => 'invalid']), 'type');

        $this->assertErrorsHas($this->storeMenu(['group' => 'invalid']), 'group');

        $this->assertErrorsHas($this->storeMenu(['link' => null]), 'link');
        $this->assertErrorsHas($this->storeMenu(['link' => str_random(256)]), 'link');

        $this->assertErrorsHas($this->storeMenu(['link_exact' => 'invalid']), 'link_exact');

        $this->assertErrorsHas($this->storeMenu(['external_link' => str_random(256)]), 'external_link');

        $this->assertErrorsHas($this->storeMenu(['target' => 'invalid']), 'target');

        $this->assertErrorsHas($this->storeMenu(['hide' => 'invalid']), 'hide');

        $this->assertErrorsHas($this->storeMenu(['hide_in_breadcrumb' => 'invalid']), 'hide_in_breadcrumb');

        $this->assertErrorsHas($this->storeMenu(['shortcut' => 'invalid']), 'shortcut');

        $this->assertErrorsHas($this->storeMenu(['shortcut_root' => 'invalid']), 'shortcut_root');
    }

    /** @test */
    public function 未授权用户不能删除menu()
    {
        $this->withExceptionHandling();

        $menu = create(Menu::class);

        $this->deleteJson(route('system.menu.destroy', ['menu' => $menu->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以删除menu()
    {
        $this->signInSystemAdmin();

        $menu = create(Menu::class);

        $this->deleteJson(route('system.menu.destroy', ['menu' => $menu->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing($menu->getTable(), ['id' => $menu->id]);
    }

    /** @test */
    public function 未授权用户不能查看menu()
    {
        $this->withExceptionHandling();

        $menu = create(Menu::class);

        $this->getJson(route('system.menu.show', ['menu' => $menu->id]))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以查看menu()
    {
        $this->signInSystemAdmin();

        /** @var Menu $menu */
        $menu = create(Menu::class);

        $resp = $this->getJson(route('system.menu.show', ['menu' => $menu->id]))
            ->assertStatus(Response::HTTP_OK)
            ->json();

        $fields = ['key', 'display_name', 'type', 'link', 'icon', 'uniqueKey', 'parent_menu', 'sort'];
        $this->assertEquals(array_only($menu->toArray(), $fields), array_only($resp, $fields));
    }

    /** @test */
    public function 未授权用户不能更新menu()
    {
        $this->withExceptionHandling();

        $menu = create(Menu::class);

        $update = ['key' => 'updated_key'];

        $this->patchJson(route('system.menu.update', ['menu' => $menu->id]), $update)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function 授权用户可以更新menu()
    {
        $this->signInSystemAdmin();

        $menu = create(Menu::class);

        $update = ['key' => 'updated_key'];

        $this->patchJson(route('system.menu.update', ['menu' => $menu->id]), $update)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas($menu->getTable(), array_merge(['id' => $menu->id], $update));
    }

    /** @test */
    public function menu表单不合法时无法更新()
    {
        $this->withExceptionHandling();

        $this->assertErrorsHas($this->updateMenu(['parent_id' => 'not a number']), 'parent_id');
        $this->assertErrorsHas($this->updateMenu(['parent_id' => -1]), 'parent_id');

        $this->assertErrorsHas($this->updateMenu(['display_name' => 123]), 'display_name');
        $this->assertErrorsHas($this->updateMenu(['display_name' => str_random(51)]), 'display_name');

        $this->assertErrorsHas($this->updateMenu(['key' => 'invalid key']), 'key');
        $this->assertErrorsHas($this->updateMenu(['key' => str_random(51)]), 'key');

        $this->assertErrorsHas($this->updateMenu(['type' => 'invalid']), 'type');

        $this->assertErrorsHas($this->updateMenu(['group' => 'invalid']), 'group');

        $this->assertErrorsHas($this->updateMenu(['link' => str_random(256)]), 'link');
        $this->assertErrorsHas($this->updateMenu(['link' => null]), 'link');

        $this->assertErrorsHas($this->updateMenu(['link_exact' => 'invalid']), 'link_exact');

        $this->assertErrorsHas($this->updateMenu(['external_link' => str_random(256)]), 'external_link');

        $this->assertErrorsHas($this->updateMenu(['target' => 'invalid']), 'target');

        $this->assertErrorsHas($this->updateMenu(['hide' => 'invalid']), 'hide');

        $this->assertErrorsHas($this->updateMenu(['hide_in_breadcrumb' => 'invalid']), 'hide_in_breadcrumb');

        $this->assertErrorsHas($this->updateMenu(['shortcut' => 'invalid']), 'shortcut');

        $this->assertErrorsHas($this->updateMenu(['shortcut_root' => 'invalid']), 'shortcut_root');
    }

    /** @test */
    public function 授权用户可以批量删除menu()
    {
        $this->signInSystemAdmin();

        $menus = create(Menu::class, 5);

        $this->deleteJson(route('system.menu.destroy', ['menu' => $menus[0]->id]),
            ['ids' => $menus->pluck('id')->toArray()])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $menus->each(function ($menu) {
            $this->assertDatabaseMissing($menu->getTable(), ['id' => $menu->id]);
        });
    }

    /**
     * 添加记录辅助函数
     *
     * @param array $override
     *
     * @return array
     */
    protected function storeMenu(array $override = [])
    {
        $this->signInSystemAdmin();

        $menu = raw(Menu::class, $override);

        return $this->postJson(route('system.menu.store'), $menu)
            ->json();
    }

    /**
     * 更新记录辅助函数
     *
     * @param array $update
     *
     * @return array
     */
    protected function updateMenu(array $update)
    {
        $this->signInSystemAdmin();

        $menu = create(Menu::class);

        return $this->patchJson(route('system.menu.update', ['menu' => $menu->id]), $update)
            ->json();
    }
}
