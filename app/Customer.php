<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];
    public function scraps()
    {
        return $this->belongsToMany('App\Scrap');
    }
    public function issues()
    {
        return $this->hasMany('App\Issue');
    }
}
