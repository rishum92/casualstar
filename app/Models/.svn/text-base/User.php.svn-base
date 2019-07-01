<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Carbon\Carbon;
use Schema;
use Image;
use App\Models\Photo;
use App\Models\Activity;
use App\Models\Tribute;
use App\Models\Interest;
use App\Models\Online;
use Auth;

class User extends MasterModel {
    use SoftDeletes;

    protected $fillable = [
      'id', 'username', 'description', 'img', 'cover', 'dob', 'email','verify_img', 'verify_check', 'text_notes', 'verify_created_at', 'registered','social','twit_enable','twit_private_enable','twit_limit','twit_private_limit','uploaded_at', 'activity', 'sent_winks_count'
    ];

    protected $visible = [
      'id', 'username', 'description', 'img', 'cover', 'dob', 'location', 'gender', 'online', 'photos','privatephotos', 'interests', 'status', 'distance', 'views', 'email', 'social', 'viewDate', 'created_at', 'paypal_url', 'cashme_url', 'cashme_url_uk', 'attemptDate', 'remember_token', 'age', 'dob', 'location','alt_url','verify_img', 'verify_check', 'text_notes', 'verify_created_at', 'registered','twit_enable','twit_private_enable','twit_limit','twit_private_limit','uploaded_at', 'activity', 'sent_winks_count', 'tributes_count', 'activity_count', 'lastLogin'
    ];

    protected $guarded = []; 

    protected $hidden = [
      'password','remember_token','title'
    ];

    public function interests()
    {
      return $this->belongsToMany('App\Models\Interest', 'user_interests')->whereNull('user_interests.deleted_at');
    }

    public function activity()
    {
      return $this->hasMany('App\Models\Activity')->where('activity', 'LOGIN');
    }

    public function orders() {
      return $this->hasMany('App\Models\Order')->where('status', 1);
    }

    public function lastLogin() {
      return $this->hasOne('App\Models\Activity')->where('activity', 'LOGIN')->latest();
    }
  
    public function photos() {
      return $this->hasMany('App\Models\Photo')->orderBy('pos');
    }

    public function tributes() {
      return $this->hasMany('App\Models\Tribute');
    }

    public function sentWinks() {
      return $this->hasMany('App\Models\Wink', 'by_user_id');
    }

    public function privatephotos() {
      return $this->hasMany('App\Models\PrivatePhoto')->orderBy('pos');
    }
    public function winks()
    {
      return $this->belongsToMany('App\Models\User', 'winks', 'user_id', 'by_user_id')->where('status', 1)->select('username','img','gender')->whereNull('winks.deleted_at')->where('replied', 0);
    }

    public function views()
    {
		return $this->belongsToMany('App\Models\User', 'profile_views', 'user_id', 'by_user_id')->select('username','img','gender')->where('status', 1)->whereNull('profile_views.deleted_at')->withPivot('created_at');
    }

    public function donationAttempts()
    {
        return $this->belongsToMany('App\Models\User', 'donation_attempts', 'user_id', 'by_user_id')->withPivot('created_at');
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Models\User', 'favorites', 'user_id', 'liked_user_id')->where('status', 1)->whereNull('favorites.deleted_at');
    }


    public static function store($data) {

		  $user = self::newModel();

      $user->username = Input::get('username');
      $user->email = Input::get('email');
      $user->password = Hash::make(Input::get('password'));
      $user->dob = Input::get('dob');
      $user->social = 0;
      $user->status = 1;

      $user->save();

    	if(array_key_exists('file', $data)) {
          $image = $data['file'];
          $ext = explode('/', $image->getMimeType());
          $x = $data['x'];
          $y = $data['y'];
          $width = $data['width'];
          $height = $data['height'];
          $rotate = $data['rotate'];

          if($ext[0] == 'image') {
              $imageInfo = getimagesize($image);
              if($ext[1] == 'jpeg' || $ext[1] == 'png' || $ext[1] == 'gif') {
                  if($ext[1] == 'jpeg') {
                      $ext = '.jpg';
                  } else {
                      $ext = '.' . $ext[1];
                  }
              } else {
                  return false;
              }
          } else {
              return false;
          }

          if (!file_exists('img/users/' . $user->id)) {
              mkdir('img/users/' . $user->id, 0777, true);
          }

          $uniqId = uniqId();
          $file = $uniqId . $ext;
          $user->img = $file;
          $user->save();

          Image::make($image->getRealPath())->save('img/users/' . $user->id . '/' . $file)->destroy();
          $userImage = Image::make('img/users/' . $user->id . '/' . $file);
          $userImage->rotate(-$rotate);
          $userImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
          $userImage->resize(400, null, function ($constraint) {
              $constraint->aspectRatio();
          });
          $userImage->save();
      }

    	return $user;
    }

    static function updateField($id, $data) {
      $allowedFields = ['email', 'description', 'password', 'img', 'cover', 'lng', 'paypal_url','cashme_url', 'cashme_url_uk', 'alt_url'];
      $alphaNumeric = ['paypal_url','cashme_url', 'cashme_url_uk'];
      if(in_array($data['key'], $allowedFields)) {
        if(in_array($data['key'], $alphaNumeric)) {
          if($data['value'] != '' && !ctype_alnum($data['value'])) {
            return;
          }
        }

        $item = User::find(Auth::user()->id);
        $item->{$data['key']} = $data['value'];
        $item->save();
        return $item;
      }
    }

}
