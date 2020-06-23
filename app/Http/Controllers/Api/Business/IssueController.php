<?php

namespace App\Http\Controllers\Api\Business;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\IssueRequest;
use App\Http\Resources\IssueResource;
use App\Issue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $date = $request->query('date', Carbon::now()->toDateString());
        $task = $request->query('task_id');
        $query = Issue::query();
        if ($task) {
            $query->whereTaskId($task);
            return IssueResource::collection($query->with('details', 'customer:id,name')->get());
        }
        $query->whereDate('date', $date);
        return IssueResource::collection($query->with('details.scrap', 'customer:id,name')->with(['task' => function ($query) {
            $query->select('id', 'user_id', 'truck_id')->with('user:id,name', 'truck:id,number_plate');
        }])->paginate($perPage));
    }
    public function update(Issue $issue, IssueRequest $request)
    {
        $details = $request->details;
        $issue->details()->delete();
        $total = 0;
        foreach ($details as $detail) {
            $issue->details()->create($detail);
            $total += $detail['quantity'];
        }
        $issue->update(['images' => $request->images, 'quantity' => $total]);
        return Response::updated();
    }
}
