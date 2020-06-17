<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrokenTruckReport extends Model
{
    protected $guarded = [];
    protected $casts = [
        'images' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function truck()
    {
        return $this->belongsTo('App\Truck');
    }
}
