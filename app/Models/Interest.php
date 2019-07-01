<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserInterest;

class Interest extends MasterModel {
    use SoftDeletes;

    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'user_interests');
    }

    public static function add($data) {
        $newInterest = new Interest();
        foreach($data as $key => $value) {
                $newInterest->$key = $value;
        }

        $newInterest->save();

        return $newInterest;
    }

    public static function remove($id) {
      $item = Interest::find($id);
      $item->delete();

      $userInterests = UserInterest::where('interest_id', $id)->get()->remove();

      return $item;
    }

}