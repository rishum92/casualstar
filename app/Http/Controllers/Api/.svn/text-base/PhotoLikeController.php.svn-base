<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as MasterController;
use App;
use Input;
use Request;
use Image;
use Auth;
use Lang;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Photo;
use App\Models\PhotoLike;
use App\Models\Notification;

class PhotoLikeController extends MasterController
{
  public function show($photo_id) {
  	$photoLikes = PhotoLike::where('photo_id', $photo_id)->get();

  	return $photoLikes;
  }

  public function store() {
  	$existingLike = PhotoLike::where('user_id', Auth::user()->id)->where('photo_id', Input::get('photo_id'))->withTrashed()->get()->first();
  	if($existingLike != NULL) {
  		if($existingLike->deleted_at == NULL) {
  			$existingLike->deleted_at = Carbon::now();
  		} else {
  			$existingLike->deleted_at = NULL;
  		}
		  $existingLike->save();
  	} else {
  		$photoLike = new PhotoLike();
  		$photoLike->user_id = Auth::user()->id;
  		$photoLike->photo_id = Input::get('photo_id');
  		$photoLike->save();

    // if(Input::get('user_id') != Auth::user()->id) {
      $notification = new Notification();
      $notification->from_id = Auth::user()->id;
      $notification->to_id = Input::get('user_id');
      $notification->message = 'New like received for photo!';
      $notification->type = 'NEW_PHOTO_LIKE';
      $notification->is_read = 'FALSE';
      $notification->save();
    // }
  	}
  }

}