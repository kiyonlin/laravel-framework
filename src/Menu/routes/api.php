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
Route::namespace('Kiyon\Laravel\Menu\Controller')
    ->prefix(config('app.api_version'))
    ->middleware(['api', 'auth'])
    ->group(function () {
        Route::prefix('menu')
            ->name('system.menu.')
            ->group(function () {
                Route::get('/', 'MenuController@index')
                    ->middleware('ability:system.menu.index')
                    ->name('index');

                Route::post('/', 'MenuController@store')
                    ->middleware('ability:system.menu.store')
                    ->name('store');

                Route::patch('/{menu}', 'MenuController@update')
                    ->middleware('ability:system.menu.update')
                    ->name('update');

                Route::delete('/{menu}', 'MenuController@destroy')
                    ->middleware('ability:system.menu.destroy')
                    ->name('destroy');
            });
    });
