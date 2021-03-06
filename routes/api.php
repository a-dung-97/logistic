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
    Route::post('images/upload', 'Api\System\UserController@uploadImage');
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
    Route::delete('customers/{customer}/scraps/{id}', 'Api\Business\CustomerController@deleteScraps');
    Route::apiResource('customers', 'Api\Business\CustomerController');
    Route::apiResource('trucks', 'Api\Business\TruckController');
    Route::put('broken-truck-reports/{broken_truck_report}/approve', 'Api\Business\BrokenTruckReportController@approve');
    Route::apiResource('broken-truck-reports', 'Api\Business\BrokenTruckReportController');
    Route::apiResource('warehouses', 'Api\Business\WarehouseController');

    Route::apiResource('works', 'Api\Business\WorkController');
    Route::get('works/{work}/tasks', 'Api\Business\WorkController@getTasks');
    Route::post('works/{work}/coordinate', 'Api\Business\WorkController@coordinate');
    Route::post('works/{work}/cancel', 'Api\Business\WorkController@cancel');
    Route::put('cancel', 'Api\Business\WorkController@cancel');
    Route::get('route-lists', 'Api\Business\WorkController@getRouteLists');
    Route::post('save-to-warehouse', 'Api\Business\WorkController@saveToWarehouse');

    Route::get('tasks', 'Api\Business\TaskController@index');
    Route::put('tasks/{task}/accept', 'Api\Business\TaskController@accept');
    Route::put('tasks/{task}/reject', 'Api\Business\TaskController@reject');
    Route::put('tasks/{task}/complete', 'Api\Business\TaskController@complete');
    Route::put('tasks/{task}/cancel', 'Api\Business\TaskController@cancel');

    Route::get('issues', 'Api\Business\IssueController@index');
    Route::get('notifications', 'Api\System\UserController@getNotifications');
    Route::put('issues/{issue}', 'Api\Business\IssueController@update');

    Route::get('report', 'Api\Business\ReportController');
});
