<?php

namespace App\Models;

use App;
use Auth;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoLike extends Model {
    use SoftDeletes;

    protected $with = ['user'];

    public function user() {
      return $this->belongsTo('App\Models\User');
    }

}