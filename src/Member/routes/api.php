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
Route::namespace('Kiyon\Laravel\Member\Controller')
    ->prefix(config('app.api_version'))
    ->middleware(['api', 'auth'])
    ->group(function () {
        Route::prefix('member')
            ->name('system.member.')
            ->group(function () {
                Route::get('/', 'MemberController@index')
                    ->middleware('ability:system.member.index')
                    ->name('index');

                Route::post('/', 'MemberController@store')
                    ->middleware('ability:system.member.store')
                    ->name('store');

                Route::get('/{member}', 'MemberController@show')
                    ->middleware('ability:system.member.show')
                    ->name('show');

                Route::patch('/{member}', 'MemberController@update')
                    ->middleware('ability:system.member.update')
                    ->name('update');

                Route::delete('/{member}', 'MemberController@destroy')
                    ->middleware('ability:system.member.destroy')
                    ->name('destroy');
            });
    });
