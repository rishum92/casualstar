<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Image;
use Auth;

class Photo extends MasterModel {
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

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
         
            if (!file_exists('img/users/' . $user->id . '/previews')) {
                mkdir('img/users/' . $user->id . '/previews', 0777, true);
            }

            $file = $user->id . '-' . $uniqId . $ext;
            Image::make($image->getRealPath())->save('img/users/' . $user->id . '/' . $file)->save('img/users/' . $user->id . '/previews/' . $file)->destroy();

            $userPreview = Image::make('img/users/' . $user->id . '/previews/' . $file);
            $userPreview->rotate(-$rotate);
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
        $photo = Photo::find($id);
        if(file_exists('img/users/' . Auth::user()->username . '/' . $photo->img)) {
            unlink('img/users/' . Auth::user()->username . '/' . $photo->img);
        }
        if(file_exists('img/users/' . Auth::user()->username . '/previews/' . $photo->img)) {
            unlink('img/users/' . Auth::user()->username . '/previews/' . $photo->img);
        }
		if(file_exists('img/users/' . Auth::user()->username . '/privatephoto/' . $photo->img)) {
            unlink('img/users/' . Auth::user()->username . '/privatephoto/' . $photo->img);
        }
        $item = self::existingModel($id);
        $item->delete();
        return $item;
    }

}
    