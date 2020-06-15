<?php

namespace App\Http\Controllers\Api\Business;

use App\Helpers\Helper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\TruckTypeRequest;
use App\Http\Resources\TruckTypeResource;
use App\TruckType;
use Illuminate\Http\Request;

class TruckTypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search');
        $query = TruckType::query();
        if ($search) $query->whereLike(['name', 'code'], '%' . $search . '%');
        return TruckTypeResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TruckTypeRequest $request)
    {
        TruckType::create($request->all());
        return Response::created();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TruckType  $truckType
     * @return \Illuminate\Http\Response
     */
    public function update(TruckTypeRequest $request, TruckType $truckType)
    {
        $truckType->update($request->all());
        return Response::updated();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TruckType  $truckType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TruckType $truckType)
    {
        return Helper::delete($truckType);
    }
}
