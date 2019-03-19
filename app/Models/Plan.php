<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends MasterModel {
    use SoftDeletes;

    public function order() {
    	return $this->hasOne('App\Models\Order');
    }
}