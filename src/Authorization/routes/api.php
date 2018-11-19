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
    ->middleware(['api', 'auth'])
    ->group(function () {
        Route::prefix('authorization')
            ->name('authorization.')
            ->group(function () {
                Route::get('/abilities', 'AuthorizationController@abilities')
                    ->name('abilities');
            });

        Route::prefix('system/permission')
            ->name('system.permission.')
            ->group(function () {
                Route::get('/', 'PermissionController@index')
                    ->middleware('ability:system.permission.index')
                    ->name('index');

                Route::post('/', 'PermissionController@store')
                    ->middleware('ability:system.permission.store')
                    ->name('store');

                Route::patch('/update/{permission}', 'PermissionController@update')
                    ->middleware('ability:system.permission.update')
                    ->name('update');

                Route::delete('/destroy/{permission}', 'PermissionController@destroy')
                    ->middleware('ability:system.permission.destroy')
                    ->name('destroy');
            });

        Route::prefix('system/role')
            ->name('system.role.')
            ->group(function () {
                Route::get('/', 'RoleController@index')
                    ->middleware('ability:system.role.index')
                    ->name('index');

                Route::post('/', 'RoleController@store')
                    ->middleware('ability:system.role.store')
                    ->name('store');

                Route::patch('/update/{role}', 'RoleController@update')
                    ->middleware('ability:system.role.update')
                    ->name('update');

                Route::delete('/destroy/{role}', 'RoleController@destroy')
                    ->middleware('ability:system.role.destroy')
                    ->name('destroy');
            });

        Route::prefix('system/organization')
            ->name('system.organization.')
            ->group(function () {
                Route::get('/', 'OrganizationController@index')
                    ->middleware('ability:system.organization.index')
                    ->name('index');

                Route::post('/', 'OrganizationController@store')
                    ->middleware('ability:system.organization.store')
                    ->name('store');

                Route::patch('/update/{organization}', 'OrganizationController@update')
                    ->middleware('ability:system.organization.update')
                    ->name('update');

                Route::delete('/destroy/{organization}', 'OrganizationController@destroy')
                    ->middleware('ability:system.organization.destroy')
                    ->name('destroy');
            });
    });
