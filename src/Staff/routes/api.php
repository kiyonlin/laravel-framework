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
    ->middleware(['api', 'auth'])
    ->group(function () {
        Route::prefix('system/staff')
            ->name('system.staff.')
            ->group(function () {
                Route::get('/', 'StaffController@index')
                    ->middleware('ability:system.staff.index')
                    ->name('index');

                Route::post('/', 'StaffController@store')
                    ->middleware('ability:system.staff.store')
                    ->name('store');

                Route::patch('/update/{staff}', 'StaffController@update')
                    ->middleware('ability:system.staff.update')
                    ->name('update');

                Route::delete('/destroy/{staff}', 'StaffController@destroy')
                    ->middleware('ability:system.staff.destroy')
                    ->name('destroy');
            });
    });
