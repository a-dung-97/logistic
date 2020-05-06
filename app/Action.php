<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
