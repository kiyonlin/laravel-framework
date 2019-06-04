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
Route::namespace('Kiyon\Laravel\Staff\Controller')
    ->prefix(config('app.api_version'))
    ->middleware(['api', 'auth'])
    ->group(function () {
        Route::prefix('staff')
            ->name('system.staff.')
            ->group(function () {
                Route::get('/', 'StaffController@index')
                    ->middleware('ability:system.staff.index')
                    ->name('index');

                Route::post('/', 'StaffController@store')
                    ->middleware('ability:system.staff.store')
                    ->name('store');

                Route::get('/{staff}', 'StaffController@show')
                    ->middleware('ability:system.staff.show')
                    ->name('show');

                Route::patch('/{staff}', 'StaffController@update')
                    ->middleware('ability:system.staff.update')
                    ->name('update');

                Route::delete('/{staff}', 'StaffController@destroy')
                    ->middleware('ability:system.staff.destroy')
                    ->name('destroy');

                // 显示员工角色分配情况
                Route::get('/{staff}/role', 'StaffRoleController@show')
                    ->middleware('ability:system.staff.show-role')
                    ->name('show-role');

                // 为员工分配角色
                Route::put('/{staff}/role', 'StaffRoleController@update')
                    ->middleware('ability:system.staff.grant-role')
                    ->name('grant-role');

                // 显示员工权限分配情况
                Route::get('/{staff}/permission', 'StaffPermissionController@show')
                    ->middleware('ability:system.staff.show-permission')
                    ->name('show-permission');

                // 为员工分配权限
                Route::put('/{staff}/permission', 'StaffPermissionController@update')
                    ->middleware('ability:system.staff.grant-permission')
                    ->name('grant-permission');

                // 显示员工组织分配情况
                Route::get('/{staff}/organization', 'StaffOrganizationController@show')
                    ->middleware('ability:system.staff.show-organization')
                    ->name('show-organization');

                // 为员工分配组织
                Route::put('/{staff}/organization', 'StaffOrganizationController@update')
                    ->middleware('ability:system.staff.grant-organization')
                    ->name('grant-organization');

                // 删除员工组织
                Route::delete('/{staff}/organization', 'StaffOrganizationController@destroy')
                    ->middleware('ability:system.staff.delete-organization')
                    ->name('delete-organization');
            });
    });
