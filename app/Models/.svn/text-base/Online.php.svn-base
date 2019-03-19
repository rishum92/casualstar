<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App;
use Auth;
use MongoDB;
use DB;

class Online extends Eloquent {

	protected $connection = 'mongodb';
	
	public static function getOnline($id) {
		$online = DB::connection('mongodb')->collection('online')->where('id', $id)->first();
		return $online;
	}

	public static function getOnlineUsers() {
		$online = DB::connection('mongodb')->collection('online')->select('id')->where('id', '!=' , Auth::user()->id)->where('gender', '!=', Auth::user()->gender)->get();
		return $online;
	}
}