<?php

namespace App\Http\Controllers\Api\Business;

use App\BrokenTruckReport;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrokenTruckReportRequest;
use App\Http\Resources\TruckResource;
use App\Notifications\BrokenTruckReportApproved;
use App\Truck;
use App\User;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;

class BrokenTruckReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->query('date');
        if (!$date) $date = Carbon::now()->toDateString();
        $perPage = $request->query('per_page', 20);
        $status = $request->query('status');
        $driver = $request->query('driver');
        $user = $request->query('user_id');
        $query = BrokenTruckReport::whereDate('created_at', $date);
        if ($status) $query->whereStatus($status);
        if ($user) $query->whereUserId($user);
        if ($driver)
            return TruckResource::collection($this->user->brokenTruckReports);
        return TruckResource::collection($query->latest('id')->with('user:id,name', 'truck:id,number_plate')->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrokenTruckReportRequest $request)
    {
        $truck = $this->user->truck;
        if (!$truck) return Response::error('Không có xe');
        $this->user->brokenTruckReports()->create(array_merge($request->all(), ['truck_id' => $truck->id, 'status' => 1]));
        return Response::created();
    }
    public function update(BrokenTruckReportRequest $request, BrokenTruckReport $brokenTruckReport)
    {
        $brokenTruckReport->update($request->all());
        return Response::updated();
    }

    public function approve(BrokenTruckReport $brokenTruckReport, Request $request)
    {
        $brokenTruckReport->update(['status' => $request->status]);
        $brokenTruckReport->user->notify(new BrokenTruckReportApproved($brokenTruckReport));
        return Response::updated();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
