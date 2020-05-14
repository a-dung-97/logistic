<?php

namespace App\Http\Controllers\Api\System;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActionRequest;
use App\Http\Resources\ActionResource;
use App\Action;
use App\Helpers\Response;
use Illuminate\Http\Request;

class ActionController extends Controller
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
        $group = $request->query('group_id');
        $query = Action::query();
        if ($search) $query->whereLike(['name'], '%' . $search . '%');
        if ($search) $query->where('action_group_id', $group);
        return ActionResource::collection($query->with('menu:id,title', 'group:id,name')->paginate($perPage));
    }

    public function getActionList()
    { }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActionRequest $request)
    {
        Action::create($request->all());
        return Response::created();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function update(ActionRequest $request, Action $action)
    {
        $action->update($request->all());
        return Response::updated();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Action $action)
    {
        return Helper::delete($action);
    }
}
