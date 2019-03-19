<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerAd extends MasterModel {
    use SoftDeletes;
    
    protected $fillable = ['date','updated_at','created_at'];

    public function request() {
        return $this->belongsTo('App\Models\BannerAdRequest', 'banner_ad_request_id');
    }
}