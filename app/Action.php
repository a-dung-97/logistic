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
    public function group()
    {
        return $this->belongsTo('App\ActionGroup', 'action_group_id');
    }
}
