<?php

use Illuminate\Database\Seeder;
use App\Action;
use App\ActionGroup;
use App\Menu;
use App\Role;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu1 = Menu::create([
            'name' => 'Người dùng',
            'path' => '/users',
            'order' => 1,
        ]);
        $menu2 = Menu::create([
            'name' => 'Quyền',
            'path' => '/roles',
            'order' => 2,
        ]);
        $menu3 = Menu::create([
            'name' => 'Menu',
            'path' => '/menus',
            'order' => 3,
        ]);
        $menu4 = Menu::create([
            'name' => 'Chức năng',
            'path' => '/actions',
            'order' => 4,
        ]);
        $menu5 = $menu4->children()->create([

            'name' => 'Nhóm chức năng',
            'path' => '/actions/action-groups',
            'order' => 1,

        ]);
        $menu6 = $menu4->children()->create([

            'name' => 'Danh sách chức năng',
            'path' => '/actions/index',
            'order' => 2,

        ]);

        $actionGroup1 = ActionGroup::create([
            'name' => 'Người dùng'
        ]);
        $actionGroup2 = ActionGroup::create([
            'name' => 'Quyền'
        ]);
        $actionGroup3 = ActionGroup::create([
            'name' => 'Menu'
        ]);
        $actionGroup4 = ActionGroup::create([
            'name' => 'Chức năng'
        ]);

        Action::create([
            'name' => 'Xem danh sách người dùng',
            'reference' => 'App\Http\Controllers\Api\System\UserController@index',
            'menu_id' => $menu1->id,
            'action_group_id' => $actionGroup1->id
        ]);
        Action::create([
            'name' => 'Thêm người dùng',
            'reference' => 'App\Http\Controllers\Api\System\UserController@store',
            'action_group_id' => $actionGroup1->id

        ]);
        Action::create([
            'name' => 'Chỉnh sửa người dùng',
            'reference' => 'App\Http\Controllers\Api\System\UserController@update',
            'action_group_id' => $actionGroup1->id

        ]);
        Action::create([
            'name' => 'Xoá người dùng',
            'reference' => 'App\Http\Controllers\Api\System\UserController@destroy',
            'action_group_id' => $actionGroup1->id

        ]);
        Action::create([
            'name' => 'Xem danh sách quyền',
            'reference' => 'App\Http\Controllers\Api\System\RoleController@index',
            'menu_id' => $menu2->id,
            'action_group_id' => $actionGroup2->id

        ]);
        Action::create([
            'name' => 'Thêm quyền',
            'reference' => 'App\Http\Controllers\Api\System\RoleController@store',
            'action_group_id' => $actionGroup2->id

        ]);
        Action::create([
            'name' => 'Chỉnh sửa quyền',
            'reference' => 'App\Http\Controllers\Api\System\RoleController@update',
            'action_group_id' => $actionGroup2->id

        ]);
        Action::create([
            'name' => 'Xoá quyền',
            'reference' => 'App\Http\Controllers\Api\System\RoleController@destroy',
            'action_group_id' => $actionGroup2->id

        ]);
        Action::create([
            'name' => 'Phân chức năng',
            'reference' => 'App\Http\Controllers\Api\System\RoleController@adjustActions',
            'action_group_id' => $actionGroup2->id

        ]);
        Action::create([
            'name' => 'Xem danh sách menu',
            'reference' => 'App\Http\Controllers\Api\System\MenuController@index',
            'menu_id' => $menu3->id,
            'action_group_id' => $actionGroup3->id,

        ]);
        Action::create([
            'name' => 'Thêm menu',
            'reference' => 'App\Http\Controllers\Api\System\MenuController@store',
            'action_group_id' => $actionGroup3->id,

        ]);
        Action::create([
            'name' => 'Chỉnh sửa menu',
            'reference' => 'App\Http\Controllers\Api\System\MenuController@update',
            'action_group_id' => $actionGroup3->id,

        ]);
        Action::create([
            'name' => 'Xoá menu',
            'reference' => 'App\Http\Controllers\Api\System\MenuController@destroy',
            'action_group_id' => $actionGroup3->id,

        ]);
        Action::create([
            'name' => 'Xem danh sách nhóm chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionGroupController@index',
            'menu_id' => $menu5->id,
            'action_group_id' => $actionGroup4->id,

        ]);
        Action::create([
            'name' => 'Thêm nhóm chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionGroupController@store',
            'action_group_id' => $actionGroup4->id,

        ]);
        Action::create([
            'name' => 'Chỉnh sửa nhóm chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionGroupController@update',
            'action_group_id' => $actionGroup4->id,

        ]);
        Action::create([
            'name' => 'Xoá nhóm chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionGroupController@destroy',
            'action_group_id' => $actionGroup4->id,

        ]);
        Action::create([
            'name' => 'Xem danh sách chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionController@index',
            'menu_id' => $menu6->id,
            'action_group_id' => $actionGroup4->id,

        ]);
        Action::create([
            'name' => 'Thêm chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionController@store',
            'action_group_id' => $actionGroup4->id,

        ]);
        Action::create([
            'name' => 'Chỉnh sửa chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionController@update',
            'action_group_id' => $actionGroup4->id,

        ]);
        Action::create([
            'name' => 'Xoá chức năng',
            'reference' => 'App\Http\Controllers\Api\System\ActionController@destroy',
            'action_group_id' => $actionGroup4->id,
        ]);
        Role::find(1)->actions()->attach(Action::all()->pluck('id')->all());
    }
}
