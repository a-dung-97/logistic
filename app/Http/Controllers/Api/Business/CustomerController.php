<?php

namespace App\Http\Controllers\Api\Business;

use App\Helpers\Helper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search');
        $query = Customer::query();
        if ($search) $query->whereLike(['name', 'code'], '%' . $search . '%');
        return CustomerResource::collection($query->select('id', 'code', 'name', 'phone_number', 'address')->orderBy('code')->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        if (!Helper::validateLatLong($request->latitude, $request->longitude))
            return Response::error('Lat, lon không hợp lệ');
        Customer::create($request->all());
        return Response::created();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        if (!Helper::validateLatLong($request->latitude, $request->longitude))
            return Response::error('Lat, lon không hợp lệ');
        $customer->update($request->all());
        return Response::updated();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        return Helper::delete($customer);
    }
    public function updateScraps(Customer $customer, Request $request)
    {
        $customer->scraps()->attach([$request->id => ['price' => $request->price]]);
        return Response::updated();
    }
    public function getScraps(Customer $customer)
    {
        return ['data' => $customer->scraps()->withPivot('price')->get()];
    }
}
