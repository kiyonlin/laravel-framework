<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kiyon\Laravel\Support\Constant;

class CreateMenusTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->default(0)->comment('父菜单id');

            $table->string('key')->comment('菜单标示');
            $table->string('display_name')->comment('展示文字');
            $table->enum('type', [Constant::MENU_SIDE_NAV, Constant::MENU_TOP_NAV])->default(Constant::MENU_SIDE_NAV)->comment('菜单类型，侧边栏菜单或者顶部菜单');
            $table->boolean('group')->default(false)->comment('是否菜单组');

            $table->string('link')->default('-')->comment('路由');
            $table->boolean('link_exact')->default(false)->comment('路由是否精准匹配，默认：`false`');
            $table->string('external_link')->nullable()->comment('外部链接');
            $table->enum('target', ['_blank', '_self', '_parent', '_top'])->nullable()->comment('外部链接打开方式');

            $table->string('icon')->nullable()->comment('图标');
            $table->unsignedInteger('badge')->nullable()->comment('徽标数，展示的数字。');
            $table->boolean('badge_dot')->default(false)->comment('徽标数，显示小红点');
            $table->string('badge_status')->default('error')->comment('徽标 Badge 颜色');

            $table->boolean('hide')->default(false)->comment('是否隐藏菜单');
            $table->boolean('hide_in_breadcrumb')->default(true)->comment('隐藏面包屑');

            $table->boolean('shortcut')->default(false)->comment('是否快捷菜单项');
            $table->boolean('shortcut_root')->default(false)->comment('快捷菜单根节点');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_menus');
    }
}
