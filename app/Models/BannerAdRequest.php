<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class BannerAdRequest extends MasterModel {
    use SoftDeletes;

    protected $fillable = ['date','updated_at','created_at','status'];

    protected $with = ['bannerAdResources', 'user'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function bannerAds()
    {
        return $this->hasMany('App\Models\BannerAd');
    }

    public function bannerAdResources()
    {
        return $this->hasMany('App\Models\BannerAdResource');
    }
}