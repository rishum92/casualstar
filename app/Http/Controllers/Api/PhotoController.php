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
use App\Models\PrivatePhoto;

class PhotoController extends MasterController
{
  	public function reorder() {
        Photo::reorder(Input::all());
        $success = Lang::get('messages.photosReordered');
        $error = Lang::get('messages.errorMsg');
        return $this->response(true, $success ,$error);
    }

    public function store() {
        $data = Input::all();
        $user = User::find(Auth::user()->id);

        $profilePhoto = $data['file'];
        $x = $data['crop']['x'];
        $y = $data['crop']['y'];
        $width = $data['crop']['width'];
        $height = $data['crop']['height'];
        $rotate = $data['crop']['rotate'];

        if(array_key_exists('file', $data)) {
            if (!file_exists('img/users/' . $user->username)) {
                mkdir('img/users/' . $user->username, 0777, true);
            }

            if (!file_exists('img/users/' . $user->username . '/previews')) {
                mkdir('img/users/' . $user->username . '/previews', 0777, true);
            }
            
            $ext = explode('/', $profilePhoto->getMimeType());

            if($ext[0] == 'image') {
                $imageInfo = getimagesize($profilePhoto);
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

            $profilePhotoFile = uniqid() . $ext;
            $profilePhoto->move('img/users/' . $user->username, $profilePhotoFile);

            $profilePhotoPreview = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
            $profilePhotoPreview->rotate(-$rotate);
            $profilePhotoPreview->crop((int) $width, (int) $height, (int) $x, (int) $y);
            $profilePhotoPreview->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $profilePhotoPreview->save('img/users/' . $user->username . '/previews/' . $profilePhotoFile);
            
            $profilePhotoImage = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
            $profilePhotoImage->rotate(-$rotate);
            $profilePhotoImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
            $profilePhotoImage->resize(900, 900, function ($constraint) {
                $constraint->aspectRatio();
            });
            $profilePhotoImage->save();

            $photo = new Photo();
            $photo->user_id = $user->id;
            $photo->img = $profilePhotoFile;
            $photo->pos = Photo::where('user_id', Auth::user()->id)->max('pos') + 1;

            if(isset($data['title'])) {
                $photo->title = $data['title'];
            }
            
            $photo->save();

           $user = User::select('id', 'username', 'img', 'description', 'gender', 'location','lat','lng', 'paypal_url', 'cashme_url')->selectRaw("YEAR(CURDATE()) - YEAR(dob) AS age")->with('photos')->with('interests')->with('winks')->with('views')->with('privatephotos')->where('id', Auth::user()->id)->get()->first();
            
            $success = Lang::get('messages.photoAdded');
            $error = Lang::get('messages.errorMsg');
            
            return $this->response($user, $success ,$error);
        } else {
            return false;
        }
    }

    public function destroy($id){
        $execute = Photo::remove($id);
        $success = Lang::get('messages.photoRemoved');
        $error = Lang::get('messages.errorMsg');
        
        return $this->response($execute, $success ,$error);
                
        }

    public function index() {
        $page = Input::get('page');
        $perPage = Input::get('perPage');
        $photos = Photo::whereHas('user', function($q) {$q->where('status', 1);})->with('user')->where("created_at",">",Carbon::now()->subDay(30))->whereNull('deleted_at')->orderBy('created_at', 'DESC')->where('hidden', 0)->limit($perPage)->skip($page * $perPage - $perPage)->get();
        $count = Photo::whereHas('user', function($q) {$q->where('status', 1);})->where("created_at",">",Carbon::now()->subDay(30))->whereNull('deleted_at')->orderBy('created_at', 'DESC')->where('hidden', 0)->count();

        $data = new \stdClass;
        $data->photos = $photos;
        $data->count = $count;

        return $this->response($data, '', '');
    }

    public function update($id) {
        $execute = Photo::updateField($id, Input::all());
        $success = Lang::get('messages.photoRemoved');
        $error = Lang::get('messages.errorMsg');
        
        return $this->response($execute, $success ,$error);
    }
}
