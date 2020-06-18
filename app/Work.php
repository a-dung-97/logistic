<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $guarded = [];
    public function customers()
    {
        return $this->belongsToMany('App\Customer');
    }
    public function truckTypes()
    {
        return $this->belongsToMany('App\TruckType')->withPivot('quantity');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
    public function issues()
    {
        return $this->hasManyThrough('App\Issue', 'App\Task');
    }
}
