<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtolower(str_replace(' ', '', $value));
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function actions()
    {
        return $this->belongsToMany('App\Action');
    }
}
