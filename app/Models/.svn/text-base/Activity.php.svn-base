<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends MasterModel {
    use SoftDeletes;

    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'user_interests');
    }
}