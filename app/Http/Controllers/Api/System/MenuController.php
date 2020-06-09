<?php

namespace App\Http\Controllers\Api\System;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Menu;
use App\Helpers\Response;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search');
        $parentMenu = $request->query('parent_menu');
        $menu = $request->query('menu_id');
        $query = Menu::latest('id');
        if ($search) $query->whereLike(['title'], '%' . $search . '%');
        if ($parentMenu) $query->whereNull('menu_id');
        if ($menu) $query->where('menu_id', $menu);
        return MenuResource::collection($query->with('parent:id,title')->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        Menu::create($request->all());
        return Response::created();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        if ($menu->id == $request->menu_id) return Response::error('Không thể chọn menu hiện tại là menu cha');
        $menu->update($request->all());
        return Response::updated();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        return Helper::delete($menu);
    }
    public function getMenuList()
    {
        $roles = $this->user->roles()->with(['actions' => function ($query) {
            $query->select('id', 'menu_id')->with(['menu' => function ($query) {
                return $query->where('priority', '<>', 0)->with('parent');
            }]);
        }])->get();
        $menu = $roles->map(function ($item) {
            return $item->actions;
        })->flatten(1)->unique(function ($item) {
            return $item->id;
        })->map(function ($item) {
            return $item->menu;
        })->filter(function ($item) {
            return $item;
        })->values()->filter(function ($item) {
            return $item->priority != 0;
        })->values()->groupBy('menu_id');
        $menu->each(function ($item, $key) use (&$menu) {
            if ($key != "") {
                $parent = clone $item[0]->parent;
                foreach ($item as $val) {
                    unset($val->parent);
                    unset($val->menu_id);
                }
                $parent['groups'] = $parent['to'];
                unset($parent->to);
                $parent['children'] = $item->sortBy('priority')->values();
                unset($parent->menu_id);
                $menu[$key] = $parent;
            } else foreach ($item as $val) {
                unset($val->parent);
                unset($val->menu_id);
            }
        });
        return $menu->values()->flatten(1)->sortBy('priority')->values();
        // return $action;
    }
}
