<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends MasterModel {
    use SoftDeletes;

    public function plan() {
    	return $this->belongsTo('App\Models\Plan');
    }
}