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

// 用户认证相关
Route::namespace('Kiyon\Laravel\Authentication\Controller')
    ->middleware('api')
    ->prefix(config('app.api_version') . '/auth')
    ->name('auth.')
    ->group(function () {
        Route::post('/login', 'AuthController@login')
            ->name('login');

        Route::get('/logout', 'AuthController@logout')
            ->middleware('auth')
            ->name('logout');

        Route::get('/refresh', 'AuthController@refresh')
            ->middleware('auth')
            ->name('refresh');

        Route::get('/info', 'AuthController@info')
            ->middleware('auth')
            ->name('info');
    });


