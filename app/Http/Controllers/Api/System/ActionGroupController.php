<?php

namespace App\Http\Controllers\Api\System;

use App\Action;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActionGroupRequest;
use App\Http\Resources\ActionGroupResource;
use App\ActionGroup;
use App\Helpers\Response;
use App\Http\Resources\ActionGroupDetailResource;
use Illuminate\Http\Request;

class ActionGroupController extends Controller
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
        $query = ActionGroup::query();
        if ($search) $query->whereLike(['name'], '%' . $search . '%');
        return ActionGroupResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActionGroupRequest $request)
    {
        ActionGroup::create($request->all());
        return Response::created();
    }

    public function detail()
    {
        return ActionGroupDetailResource::collection(ActionGroup::with('actions:id,name,action_group_id')->get());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActionGroup  $actionGroup
     * @return \Illuminate\Http\Response
     */
    public function update(ActionGroupRequest $request, ActionGroup $actionGroup)
    {
        $actionGroup->update($request->all());
        return Response::updated();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActionGroup  $actionGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActionGroup $actionGroup)
    {
        return Helper::delete($actionGroup);
    }
}
