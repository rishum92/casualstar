<?php

namespace App\Models;

use App;
use Auth;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoComment extends Model {
    use SoftDeletes;

    protected $with = ['user'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user() {
      return $this->belongsTo('App\Models\User');
    }

}