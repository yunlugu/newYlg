<?php

namespace App\Models;
use DB;

// use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends MyBaseModel
{
    // use SoftDeletes;

    public function department()
    {
        return $this->belongsTo('\App\Models\Department');
    }

    public function members()
    {
        return $this->hasMany('\App\Models\Member');
    }

}
