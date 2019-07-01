<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Image;
use Auth;

class Wink extends MasterModel {
    use SoftDeletes;

    public function user() {
        return $this->hasOne('App\Models\User');
    }

}