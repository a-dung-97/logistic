<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'truck_id' => $this->truck_id,
            'number_plate' => $this->truck->number_plate,
            'name' => $this->user->name,
            'time' => $this->time,
            'status' => $this->status
        ];
    }
}
