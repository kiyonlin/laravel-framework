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
    ->prefix('authorization')
    ->name('authorization.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/abilities', 'AuthorizationController@abilities')
            ->name('abilities');
    });
