<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class BannerAdResource extends MasterModel {
    use SoftDeletes;

    protected $fillable = ['updated_at','created_at'];

}