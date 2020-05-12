<?php

namespace App\Http\Resources;

use App\Action;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $roles = $this->role()->with(['actions' => function ($query) {
        //     $query->select('id', 'menu_id')->with('menu.parent');
        // }])->first();
        $role = $this->role;
        $menus =  $role->actions()->select('id', 'menu_id')->with('menu.parent')->get();
        $routes = $menus->map(function ($item) {
            return $item->menu ? $item->menu->title : null;
        })->filter(function ($item) {
            return $item;
        })->values();
        $menus = $this->getMenuList($menus);
        $homeUrl = $role->home_url;
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'routes' => $routes,
            'roles' => [$role->code],
            'menus' => $menus,
            'home_url' => $homeUrl

        ];
    }
    private function getMenuList($menu)
    {
        $menu = $menu->map(function ($item) {
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
                $parent['group'] = $parent['to'];
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
