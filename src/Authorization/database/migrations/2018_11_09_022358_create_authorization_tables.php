<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kiyon\Laravel\Authentication\Model\User;
use Kiyon\Laravel\Authorization\Model\Role;
use Kiyon\Laravel\Support\Constant;

class CreateAuthorizationTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('sys_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('sys_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('key');
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('level')->default('1');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->unique(['parent_id', 'key']);
        });


        // Create table for associating roles to users (Many-to-Many)
        Schema::create('sys_role_user', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for associating organizations to users (Many-to-Many)
        Schema::create('sys_organization_user', function (Blueprint $table) {
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('user_id');

            $table->primary(['user_id', 'organization_id']);
        });

        // Create table for associating organizations to roles (Many-to-Many)
        Schema::create('sys_organization_role', function (Blueprint $table) {
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('role_id');

            $table->primary(['organization_id', 'role_id']);
        });

        // Create table for associating users to permissions (Many-to-Many)
        Schema::create('sys_permission_user', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('user_id');
            $table->text('entities')->nullable();

            $table->primary(['user_id', 'permission_id']);
        });

        // Create table for associating organizations to permissions (Many-to-Many)
        Schema::create('sys_organization_permission', function (Blueprint $table) {
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('permission_id');
            $table->text('entities')->nullable();

            $table->primary(['organization_id', 'permission_id'], 'sys_org_perm_org_id_perm_id_primary');
        });

        // Create table for associating roles to permissions (Many-to-Many)
        Schema::create('sys_permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');
            $table->text('entities')->nullable();

            $table->primary(['role_id', 'permission_id']);
        });

        $this->setupInitData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_roles');
        Schema::dropIfExists('sys_organizations');
        Schema::dropIfExists('sys_permissions');
        Schema::dropIfExists('sys_role_user');
        Schema::dropIfExists('sys_organization_user');
        Schema::dropIfExists('sys_organization_role');
        Schema::dropIfExists('sys_permission_user');
        Schema::dropIfExists('sys_organization_permission');
        Schema::dropIfExists('sys_permission_role');
    }

    /**
     * 设置初始化数据
     */
    private function setupInitData()
    {
        // 创建初始化角色
        create(Role::class, ['key' => Constant::ROLE_SYSTEM_ADMIN, 'display_name' => '系统管理员', 'description' => '']);
        create(Role::class, ['key' => Constant::ROLE_MEMBER, 'display_name' => '会员', 'description' => '']);
        create(Role::class, ['key' => Constant::ROLE_STAFF, 'display_name' => '员工', 'description' => '']);

        // 创建初始化管理员
        createSystemAdmin([
            'username' => 'kiyon',
            'display_name' => 'kiyon',
            'mobile' => '13675822217',
            'email' => 'kiyonlin@163.com',
            'password' => 'admin.amyfair',
        ]);
    }
}
