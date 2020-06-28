<?php

namespace App\Http\Controllers\Api\Business;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerReportResource;
use App\Http\Resources\DriverReportResource;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $date = $request->query('date', [Carbon::now()->toDateString(), Carbon::now()->toDateString()]);
        $type = $request->query('type', 'driver');
        if ($type === 'driver') {
            $query = Task::whereHas('work', function ($query) use ($date) {
                $query->whereBetween('date', $date);
            })->with('issues:id,quantity,task_id', 'user:id,name')->with(['truck' => function ($query) {
                $query->select('id', 'truck_type_id', 'number_plate')->with('type:id,name,tonnage');
            }])->get();
            return DriverReportResource::collection($query);
        }
        $query = Customer::whereHas('issues', function ($query) use ($date) {
            $query->whereBetween('date', $date);
        })->with('issues:id,quantity,customer_id')->get();
        return CustomerReportResource::collection($query);
    }
}
