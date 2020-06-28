<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverReportResource extends JsonResource
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
            'driver' => $this->user->name,
            'number_plate' => $this->truck->number_plate,
            'type' => $this->truck->type->name,
            'quantity' => $this->issues->sum('quantity'),
            'efficiency' => round($this->issues->sum('quantity') * 100 / ($this->truck->type->tonnage * 1000), 2)
        ];
    }
}
