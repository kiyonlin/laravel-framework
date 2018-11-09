<?php
/**
 * Created by IntelliJ IDEA.
 * User: kiyon
 * Date: 2018/11/9
 * Time: 9:06 PM
 */

namespace Tests\Unit\Menu;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Kiyon\Laravel\Menu\Menu;
use Tests\TestCase;

class MenuTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function 菜单有子菜单()
    {
        $menu = create(Menu::class);
        $this->assertInstanceOf(Collection::class, $menu->subMenus);
    }

    /** @test */
    public function 菜单有父菜单()
    {
        $menu = create(Menu::class);
        $this->assertNUll($menu->parentMenu);

        $subMenu = create(Menu::class, ['parent_id' => $menu->id]);
        $this->assertInstanceOf(Menu::class, $subMenu->parentMenu);
    }
}