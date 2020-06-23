<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $guarded = [];
    protected $casts = [
        'images' => 'array'
    ];
    public function details()
    {
        return $this->hasMany('App\IssueDetail');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
