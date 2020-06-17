<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\WorkRequest;
use App\Notifications\NewTask;
use App\Notifications\TaskCanceled;
use App\Task;
use App\Truck;
use App\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function store(WorkRequest $request)
    {
        $work = Work::create([
            'date' => $request->date,
            'time' => $request->time,
            'shift' => $request->shift,
            'user_id' => $this->user->id,
            'status' => 1
        ]);
        $work->customers()->attach($request->customers);
        foreach ($request->truck_types as $type) {
            $work->truckTypes()->attach([$type->id => ['quantity' => $type->quantity]]);
        }
        $work->truck_type()->attach($request->customers);
        return Response::created();
    }
    public function update(WorkRequest $request, Work $work)
    {
        if ($work->status != 1) return Response::error('Không thể cập nhật công việc này');
        $work->update([
            'date' => $request->date,
            'time' => $request->time,
            'shift' => $request->shift,
        ]);
        $work->customers()->sync($request->customers);
        $work->truckTypes()->detach();
        foreach ($request->truck_types as $type) {
            $work->truckTypes()->attach([$type->id => ['quantity' => $type->quantity]]);
        }
        return Response::updated();
    }
    public function coordinate(Work $work, CoordinationRequest $request)
    {
        $trucks = $request->trucks;
        $customers = $work->customers()->get('id')->pluck('id')->all();
        foreach ($trucks as $truck) {
            $user = Truck::find($truck->id);
            if (!$user) continue;
            $task = $work->tasks()->create([
                'truck_id' => $truck->id,
                'time' => $truck->time,
                'user_id' => $user->id,
                'work_id' => $request->work_id,
                'status' => 1,
            ]);
            foreach ($customers as $customerId) {
                $task->issues()->create([
                    'customer_id' => $customerId,
                    'date' => $work->date,
                    'shift' => $work->shift,
                    'quantity' => 0
                ]);
            }
            $user->notify(new NewTask($task));
        }
        $work->update(['status' => 2]);
        return Response::created();
    }
    public function cancel(Work $work)
    {
        $work->update(['status' => 3]);
        $work->tasks()->update(['status' => 5]);
        $users = $work->tasks()->get('user_id')->pluck('user_id')->all();
        foreach ($users as $userId) {
            User::find($userId)->notify(new TaskCanceled($task));
        }
        return Response::updated();
    }
}
