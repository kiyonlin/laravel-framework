<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

            $table->primary(['organization_id', 'permission_id']);
        });

        // Create table for associating roles to permissions (Many-to-Many)
        Schema::create('sys_permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');
            $table->text('entities')->nullable();

            $table->primary(['role_id', 'permission_id']);
        });
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
}
