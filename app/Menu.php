<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public function children()
    {
        return $this->hasMany('App\Menu');
    }
    public function parent()
    {
        return $this->belongsTo('App\Menu');
    }
}
