<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Image;
use Auth;

class PrivatePhoto extends MasterModel {
    use SoftDeletes;

    public static function add($data) {
        if(array_key_exists('file', $data)) {
            $image = $data['file'];
            $ext = explode('/', $image->getMimeType());
            $x = $data['crop']['x'];
            $y = $data['crop']['y'];
            $width = $data['crop']['width'];
            $height = $data['crop']['height'];
            $rotate = $data['crop']['rotate'];

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

            $user = User::find(Auth::user()->id);
            $uniqId = uniqId();

            if (!file_exists('img/users/' . $user->id)) {
                mkdir('img/users/' . $user->id, 0777, true);
            }
         
            if (!file_exists('img/users/' . $user->id . '/privatephoto')) {
                mkdir('img/users/' . $user->id . '/privatephoto', 0777, true);
            }

            $file = $user->id . '-' . $uniqId . $ext;
            Image::make($image->getRealPath())->save('img/users/' . $user->id . '/' . $file)->save('img/users/' . $user->id . '/privatephoto/' . $file)->destroy();

            $userPreview->rotate(-$rotate);
            $userPreview = Image::make('img/users/' . $user->id . '/privatephoto/' . $file);
            $userPreview->crop((int) $width, (int) $height, (int) $x, (int) $y);
            $userPreview->resize(540, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $userPreview->save();
            
            $galleryImage = Image::make('img/users/' . $user->id . '/' . $file);
            $galleryImage->rotate(-$rotate);
            $galleryImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
            $galleryImage->resize(1440, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $galleryImage->save();

            $userPhoto = new Photo();
            foreach($data as $key => $value) {
                if($key !== 'file' && $key !== 'crop') {
                    $userPhoto->$key = $value;
                } 
            }
            $userPhoto->img = $file;
            $userPhoto->save();
			
			// APInfo starts (Notification to Favorite Users)
			$favorite = Favorite::where('liked_user_id', $user->id)->WhereNotNull('deleted_at')->get();
			foreach($favorite as $favUser){
				$notification = new Notification;
				$notification->from_id = $favUser->liked_user_id;
				$notification->to_id   = $favUser->user_id;
				$notification->message = 'New Private Gallery Upload.'; 
				$notification->type    = 'PRIVATE_GALLERY_UPLOAD'; 
				$notification->is_read = 'FALSE'; 
				$notification->save();
			}
			// APInfo Ends
        }
        return $userPhoto;
    }

    public static function reorder($data) {
        foreach($data as $key => $item) {
            $item = self::existingModel($item['id']);
            $item->pos = $key;
            $item->save();
        }
    }

    static function remove($id) {
        $photo = PrivatePhoto::find($id);
        if(file_exists('img/users/' . Auth::user()->username . '/' . $photo->img)) {
            unlink('img/users/' . Auth::user()->username . '/' . $photo->img);
        }
        if(file_exists('img/users/' . Auth::user()->username . '/privatephoto/' . $photo->img)) {
            unlink('img/users/' . Auth::user()->username . '/privatephoto/' . $photo->img);
        }
        $item = self::existingModel($id);
        $item->delete();
        return $item;
    }

}
    