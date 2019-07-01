<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Activity extends MasterModel {
    use SoftDeletes;

    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'user_interests');
    }
    public static function getOnlineActive($id) {
		$online = DB::table('activities')->where('user_id', $id)->orderBy('created_at', 'DESC')->first();
		//echo "<pre>";print_r($online);die;
		return $online;
	}
}