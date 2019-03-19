<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as MasterController;
use App;
use Input;
use Request;
use Image;
use Auth;
use Lang;
use App\Models\User;
use App\Models\Favorite;

class FavoriteController extends MasterController
{
    public function destroy($username) {
        $userToRemove = User::where('username', $username)->first();
        $idToRemove = Favorite::where('user_id', Auth::user()->id)->where('liked_user_id', $userToRemove->id)->get()->first()->id;
        $execute = Favorite::remove($idToRemove);
        $success = Lang::get('messages.favoriteRemoved');
        $error = Lang::get('messages.errorMsg');
        return $this->response($execute, $success ,$error);
                
    }

    public function toggleFavorite($username) {
        $user = User::where('username', $username)->first();
        $favorite = Favorite::where('liked_user_id', $user->id)->where('user_id', Auth::user()->id)->first();
        if($favorite) {
            // $favorite->delete();
            return $this->response(NULL, '', 'You have already added this user to your favourites.');
        } else {
            $favorite = new Favorite();
            $favorite->liked_user_id = $user->id;
            $favorite->user_id = Auth::user()->id;
            $favorite->save();

            return $this->response($favorite, Lang::get('messages.favoriteAdded'), '');

            return 1;
        }
    }
}