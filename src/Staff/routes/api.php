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

                // 为员工分配角色
                Route::put('/{staff}/role', 'StaffGrantController@role')
                    ->middleware('ability:system.staff.grant-role')
                    ->name('grant-role');

                // 为员工分配权限
                Route::put('/{staff}/permission', 'StaffGrantController@permission')
                    ->middleware('ability:system.staff.grant-permission')
                    ->name('grant-permission');
            });
    });
