<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $guarded = [];
    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }
}
