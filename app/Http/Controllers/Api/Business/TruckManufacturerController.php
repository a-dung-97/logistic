<?php

namespace App\Http\Controllers\Api\Business;

use App\Helpers\Helper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\TruckManufacturerRequest;
use App\Http\Resources\TruckManufacturerResource;
use App\TruckManufacturer;
use Illuminate\Http\Request;

class TruckManufacturerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search');
        $query = TruckManufacturer::query();
        if ($search) $query->whereLike(['name', 'code'], '%' . $search . '%');
        return TruckManufacturerResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TruckManufacturerRequest $request)
    {
        TruckManufacturer::create($request->all());
        return Response::created();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TruckManufacturer  $truckManufacturer
     * @return \Illuminate\Http\Response
     */
    public function update(TruckManufacturerRequest $request, TruckManufacturer $truckManufacturer)
    {
        $truckManufacturer->update($request->all());
        return Response::updated();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TruckManufacturer  $truckManufacturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TruckManufacturer $truckManufacturer)
    {
        return Helper::delete($truckManufacturer);
    }
}
