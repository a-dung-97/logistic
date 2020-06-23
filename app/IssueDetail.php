<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssueDetail extends Model
{
    protected $guarded = [];
    public function scrap()
    {
        return $this->belongsTo('App\Scrap');
    }
}
