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
    });
