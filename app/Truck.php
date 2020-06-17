<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $guarded = [];
    public function type()
    {
        return $this->belongsTo('App\TruckType', 'truck_type_id');
    }
    public function manufacturer()
    {
        return $this->belongsTo('App\TruckManufacturer', 'truck_manufacturer_id');
    }
    public function driver()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
