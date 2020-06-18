<?php

namespace App\Http\Controllers\Api\Business;

use App\Http\Controllers\Controller;
use App\Helpers\Response;
use App\Http\Requests\RejectTaskRequest;
use App\Http\Resources\TaskResource;
use App\Notifications\TaskCanceled;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', [Carbon::now()->toDateString(), Carbon::now()->toDateString()]);
        $id = $request->query('id');
        if ($id) return new TaskResource(Task::find($id));
        $query = $this->user->tasks()->whereHas('work', function ($query) use ($date) {
            $query->whereBetween('date', $date);
        })->select('id', 'time', 'status', 'reason_for_cancellation', 'work_id')->with(['work' => function ($query) {
            $query->select('id', 'date', 'shift')->with('customers:id,name,code,phone_number,latitude,longitude,address');
        }])->get();
        return TaskResource::collection($query);
    }
    public function accept(Task $task)
    {
        $task->update(['status' => 2]);
        return Response::updated();
    }
    public function reject(Task $task, RejectTaskRequest $request)
    {
        $task->update(['status' => 3, 'reason_for_cancellation' => $request->reason_for_cancellation]);
        $task->issues()->delete();
        return Response::updated();
    }
    public function complete(Task $task)
    {
        $task->update(['status' => 4]);
        return Response::updated();
    }
    public function cancel(Task $task)
    {
        $task->update(['status' => 5]);
        $task->user->notify(new TaskCanceled($task));
        return Response::updated();
    }
}
