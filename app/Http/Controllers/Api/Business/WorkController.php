<?php

namespace App\Http\Controllers\Api\Business;

use App\Http\Controllers\Controller;
use App\Helpers\Response;
use App\Http\Requests\CoordinationRequest;
use App\Http\Requests\WorkRequest;
use App\Http\Resources\RouteListResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\WorkResource;
use App\Notifications\NewTask;
use App\Notifications\TaskCanceled;
use App\Receipt;
use App\Task;
use App\Truck;
use App\User;
use App\Work;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $date = $request->query('date', Carbon::now()->toDateString());
        $status = $request->query('status');
        $query = Work::where('date', $date);
        if ($status) $query->where('status', $status);
        return WorkResource::collection($query->with('user:id,name', 'customers:id,code', 'truckTypes:id,name', 'coordinator:id,name')->paginate($perPage));
    }
    public function store(WorkRequest $request)
    {
        try {
            DB::beginTransaction();
            $work = Work::create([
                'date' => $request->date,
                'shift' => $request->shift,
                'status' => 1,
                'user_id' => $this->user->id
            ]);
            $work->customers()->attach($request->customers);
            foreach ($request->truck_types as $type) {
                $work->truckTypes()->attach([$type['id'] => ['quantity' => $type['quantity']]]);
            }
            DB::commit();
            return Response::created();
        } catch (Exception $exception) {
            DB::rollback();
            return Response::error($exception);
        }
    }
    public function update(WorkRequest $request, Work $work)
    {
        if ($work->status != 1) return Response::error('Không thể cập nhật công việc này');
        $work->update([
            'date' => $request->date,
            'shift' => $request->shift,
        ]);
        $work->customers()->sync($request->customers);
        $work->truckTypes()->detach();
        foreach ($request->truck_types as $type) {
            $work->truckTypes()->attach([$type['id'] => ['quantity' => $type['quantity']]]);
        }
        return Response::updated();
    }
    public function coordinate(Work $work, CoordinationRequest $request)
    {
        $trucks = $request->trucks;
        $customers = $work->customers()->pluck('id')->all();
        foreach ($trucks as $truck) {
            $driver = Truck::find($truck['truck_id'])->driver;
            if (!$driver) continue;
            $task = $work->tasks()->create([
                'truck_id' => $truck['truck_id'],
                'time' => $truck['time'],
                'user_id' => $driver->id,
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
            $driver->notify(new NewTask($task));
        }
        if ($work->status != 2)
            $work->update([
                'status' => 2, 'coordinator_id' => $this->user->id
            ]);
        return Response::created();
    }
    public function cancel(Work $work)
    {
        $work->update(['status' => 3]);
        if ($work->status != 1) {
            $work->issues()->delete();
            $work->tasks()->update(['status' => 5]);
            $users = $work->tasks()->get('user_id')->pluck('user_id')->all();
            foreach ($users as $userId) {
                User::find($userId)->notify(new TaskCanceled($work->tasks()->whereUserId($userId)->first()));
            }
        }
        return Response::updated();
    }
    public function getTasks(Work $work)
    {
        return  TaskResource::collection($work->tasks()->select('id', 'truck_id', 'user_id', 'status', 'time', 'work_id')->with('truck:id,number_plate', 'user:id,name')->get());
    }
    public function getRouteLists(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $date = $request->query('date', Carbon::now()->toDateString());
        $status = $request->query('status');
        $query = Task::whereHas('work', function ($query) use ($date) {
            $query->whereDate('date', $date);
        });
        $saveToWarehouse = $request->query('save_to_warehouse');
        if (isset($saveToWarehouse)) {
            if ($saveToWarehouse == 1) $query->has('receipt');
            else $query->doesntHave('receipt');
        }
        if ($status) $query->where('status', $status);
        $query->with('truck:id,number_plate', 'user:id,name')->with(['work' => function ($query) {
            $query->with('customers:id,name')->with(['truckTypes' => function ($query) {
                $query->withPivot('quantity');
            }]);
        }]);
        return RouteListResource::collection($query->with('receipt.warehouse')->paginate($perPage));
    }
    public function saveToWarehouse(Request $request)
    {
        Receipt::create([
            'task_id' => $request->task_id,
            'quantity' => Task::find($request->task_id)->issues()->sum('quantity'),
            'warehouse_id' => $request->warehouse_id,
            'date' => Carbon::now()->toDateString()
        ]);
        return Response::created();
    }
}
