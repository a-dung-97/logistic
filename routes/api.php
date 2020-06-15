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
    Route::post('password/change', 'Api\System\AuthController@changePassword');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('users/avatar', 'Api\System\UserController@changeAvatar');
    Route::apiResource('users', 'Api\System\UserController');
    Route::put('roles/{role}/actions', 'Api\System\RoleController@updateActions');
    Route::apiResource('roles', 'Api\System\RoleController');
    Route::apiResource('actions', 'Api\System\ActionController');
    Route::get('action-groups/detail', 'Api\System\ActionGroupController@detail');
    Route::apiResource('action-groups', 'Api\System\ActionGroupController');
    Route::get('menus/list', 'Api\System\MenuController@getMenuList');
    Route::apiResource('menus', 'Api\System\MenuController');
    Route::apiResource('truck-manufacturers', 'Api\Business\TruckManufacturerController');
    Route::apiResource('truck-types', 'Api\Business\TruckTypeController');
    Route::apiResource('scrap', 'Api\Business\ScrapController');
    Route::get('customers/{customer}/scraps', 'Api\Business\CustomerController@getScraps');
    Route::put('customers/{customer}/scraps', 'Api\Business\CustomerController@updateScraps');
    Route::apiResource('customers', 'Api\Business\CustomerController');
    Route::apiResource('customers', 'Api\Business\CustomerController');
});
