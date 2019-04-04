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

                Route::post('/', 'PermissionController@store')
                    ->middleware('ability:system.permission.store')
                    ->name('store');

                Route::patch('/{permission}', 'PermissionController@update')
                    ->middleware('ability:system.permission.update')
                    ->name('update');

                Route::delete('/{permission}', 'PermissionController@destroy')
                    ->middleware('ability:system.permission.destroy')
                    ->name('destroy');
            });

        Route::prefix('role')
            ->name('system.role.')
            ->group(function () {
                Route::get('/', 'RoleController@index')
                    ->middleware('ability:system.role.index')
                    ->name('index');

                Route::post('/', 'RoleController@store')
                    ->middleware('ability:system.role.store')
                    ->name('store');

                Route::patch('/{role}', 'RoleController@update')
                    ->middleware('ability:system.role.update')
                    ->name('update');

                Route::delete('/{role}', 'RoleController@destroy')
                    ->middleware('ability:system.role.destroy')
                    ->name('destroy');
            });

        Route::prefix('organization')
            ->name('system.organization.')
            ->group(function () {
                Route::get('/', 'OrganizationController@index')
                    ->middleware('ability:system.organization.index')
                    ->name('index');

                Route::post('/', 'OrganizationController@store')
                    ->middleware('ability:system.organization.store')
                    ->name('store');

                Route::patch('/{organization}', 'OrganizationController@update')
                    ->middleware('ability:system.organization.update')
                    ->name('update');

                Route::delete('/{organization}', 'OrganizationController@destroy')
                    ->middleware('ability:system.organization.destroy')
                    ->name('destroy');
            });
    });
