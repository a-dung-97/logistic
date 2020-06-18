<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    public function issues()
    {
        return $this->hasMany('App\Issue');
    }
    public function work()
    {
        return $this->belongsTo('App\Work');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function truck()
    {
        return $this->belongsTo('App\Truck');
    }
}
