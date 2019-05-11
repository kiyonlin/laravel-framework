<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 用户授权相关
Route::namespace('Kiyon\Laravel\Authorization\Controller')
    ->prefix(config('app.api_version'))
    ->middleware(['api', 'auth'])
    ->group(function () {
        Route::prefix('authorization')
            ->name('authorization.')
            ->group(function () {
                Route::get('/abilities', 'AuthorizationController@abilities')
                    ->name('abilities');
            });

        Route::prefix('permission')
            ->name('system.permission.')
            ->group(function () {
                Route::get('/', 'PermissionController@index')
                    ->middleware('ability:system.permission.index')
                    ->name('index');

                Route::get('/{permission}', 'PermissionController@show')
                    ->middleware('ability:system.permission.show')
                    ->name('show');

                Route::post('/', 'PermissionController@store')
                    ->middleware('ability:system.permission.store')
                    ->name('store');

                Route::patch('/{permission}', 'PermissionController@update')
                    ->middleware('ability:system.permission.update')
                    ->name('update');

                Route::delete('/{permission}', 'PermissionController@destroy')
                    ->middleware('ability:system.permission.destroy')
                    ->name('destroy');

                // 为权限分配用户
                Route::put('/{permission}/user', 'PermissionGrantController@user')
                    ->middleware('ability:system.permission.grant-user')
                    ->name('grant-user');

                // 为权限分配角色
                Route::put('/{permission}/role', 'PermissionGrantController@role')
                    ->middleware('ability:system.permission.grant-role')
                    ->name('grant-role');

                // 为权限分配组织
                Route::put('/{permission}/organization', 'PermissionGrantController@organization')
                    ->middleware('ability:system.permission.grant-organization')
                    ->name('grant-organization');
            });

        Route::prefix('role')
            ->name('system.role.')
            ->group(function () {
                Route::get('/', 'RoleController@index')
                    ->middleware('ability:system.role.index')
                    ->name('index');

                Route::get('/{role}', 'RoleController@show')
                    ->middleware('ability:system.role.show')
                    ->name('show');

                Route::post('/', 'RoleController@store')
                    ->middleware('ability:system.role.store')
                    ->name('store');

                Route::patch('/{role}', 'RoleController@update')
                    ->middleware('ability:system.role.update')
                    ->name('update');

                Route::delete('/{role}', 'RoleController@destroy')
                    ->middleware('ability:system.role.destroy')
                    ->name('destroy');

                // 为角色分配用户
                Route::put('/{role}/user', 'RoleUserController@update')
                    ->middleware('ability:system.role.grant-user')
                    ->name('grant-user');

                // 显示角色分配权限情况
                Route::get('/{role}/permission', 'RolePermissionController@show')
                    ->middleware('ability:system.role.show-permission')
                    ->name('show-permission');

                // 为角色分配权限
                Route::put('/{role}/permission', 'RolePermissionController@update')
                    ->middleware('ability:system.role.grant-permission')
                    ->name('grant-permission');
            });

        Route::prefix('organization')
            ->name('system.organization.')
            ->group(function () {
                Route::get('/', 'OrganizationController@index')
                    ->middleware('ability:system.organization.index')
                    ->name('index');

                Route::get('/{organization}', 'OrganizationController@show')
                    ->middleware('ability:system.organization.show')
                    ->name('show');

                Route::post('/', 'OrganizationController@store')
                    ->middleware('ability:system.organization.store')
                    ->name('store');

                Route::patch('/{organization}', 'OrganizationController@update')
                    ->middleware('ability:system.organization.update')
                    ->name('update');

                Route::delete('/{organization}', 'OrganizationController@destroy')
                    ->middleware('ability:system.organization.destroy')
                    ->name('destroy');

                // 为组织分配用户
                Route::put('/{organization}/user', 'OrganizationGrantController@user')
                    ->middleware('ability:system.organization.grant-user')
                    ->name('grant-user');

                // 为组织分配权限
                Route::put('/{organization}/permission', 'OrganizationGrantController@permission')
                    ->middleware('ability:system.organization.grant-permission')
                    ->name('grant-permission');
            });
    });
