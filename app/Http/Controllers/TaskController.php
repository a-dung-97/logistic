<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Resources\TaskResource;
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
        })->with('work.customers')->get();
        return TaskResource::collection($query);
    }
    public function accept(Task $task)
    {
        $task->update(['status' => 2]);
        return Response::updated();
    }
    public function reject(Task $task, Request $request)
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
}
