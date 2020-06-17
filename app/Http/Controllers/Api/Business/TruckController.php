<?php

namespace App\Http\Controllers\Api\Business;

use App\Helpers\Helper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\TruckRequest;
use App\Http\Resources\TruckResource;
use App\Truck;
use App\User;
use Error;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search');
        $truckType = $request->query('truck_type_id');
        $truckManufacturer = $request->query('truck_manufacturer_id');
        $query = Truck::query();
        if ($search) $query->whereLike(['number_blate'], '%' . $search . '%');
        if ($truckType) $query->where('truck_type_id', $truckType);
        if ($truckManufacturer) $query->where('truck_manufacturer_id', $truckManufacturer);
        return TruckResource::collection($query->with('type:id,name', 'manufacturer:id,name', 'driver:id,name')->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TruckRequest $request)
    {
        if (User::find($request->id)->truck()->count() > 0) return Response::error('Lái xe này đã có xe');
        Truck::create($request->all());
        return Response::created();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(TruckRequest $request, Truck $truck)
    {
        if ($truck->user_id != $request->user_id && User::find($request->id)->truck()->count() > 0) return Response::error('Lái xe này đã có xe');
        $truck->update($request->all());
        return Response::updated();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {
        return Helper::delete($truck);
    }
}
