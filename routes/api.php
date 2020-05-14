<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'Api\System\AuthController@login');
    Route::post('logout', 'Api\System\AuthController@logout');
    Route::post('refresh', 'Api\System\AuthController@refresh');
    Route::post('me', 'Api\System\AuthController@me');
});

Route::group(['middleware' => ['auth']], function () {
    Route::apiResource('users', 'Api\System\UserController');
    Route::put('roles/{role}/actions', 'Api\System\RoleController@updateActions');
    Route::apiResource('roles', 'Api\System\RoleController');
    Route::apiResource('actions', 'Api\System\ActionController');
    Route::get('action-groups/detail', 'Api\System\ActionGroupController@detail');
    Route::apiResource('action-groups', 'Api\System\ActionGroupController');
    Route::get('menus/list', 'Api\System\MenuController@getMenuList');
    Route::apiResource('menus', 'Api\System\MenuController');
});
