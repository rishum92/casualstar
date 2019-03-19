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
use App\Models\PhotoComment;
use App\Models\Notification;

class PhotoCommentController extends MasterController
{
  public function show($photo_id) {
    $photoComments = PhotoComment::where('photo_id', $photo_id)->orderBy('created_at','DESC')->get();
    foreach($photoComments as $key => $photoComment) {
      if($photoComment->user->status == 0) {
        unset($photoComments[$key]);
      } else {
        $photoComment->posted = $photoComment->created_at->diffForHumans();
      }
    }
    return $photoComments;
  }

  public function store() {
  	$photoComment = new PhotoComment();
  	$photoComment->user_id = Auth::user()->id;
  	$photoComment->text = Input::get('comment');
  	$photoComment->photo_id = Input::get('photo_id');
  	$photoComment->save();

    // if(Input::get('user_id') != Auth::user()->id) {
      $notification = new Notification();
      $notification->from_id = Auth::user()->id;
      $notification->to_id = Input::get('user_id');
      $notification->message = 'New comment on photo!';
      $notification->type = 'NEW_PHOTO_COMMENT';
      $notification->is_read = 'FALSE';
      $notification->save();
    // }

  	return $this->response($photoComment, 'Comment added!', '');
  }

  public function destroy($id) {
    $photoComment = PhotoComment::find($id);
    if($photoComment != null && $photoComment->user_id == Auth::user()->id) {
      $photoComment->delete();
    }

    return $this->response($photoComment, 'Comment deleted!', '');
  }

}