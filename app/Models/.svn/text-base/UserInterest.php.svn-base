<?php

namespace App\Models;

use App;
use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Interest;
use App\Models\UserInterest;

class UserInterest extends MasterModel {
    use SoftDeletes;

    public function interest() {
    	return $this->belongsTo('App\Models\Interest');
    }

    public static function getAllUnassigned($searchString) {
		$existingInterests = UserInterest::where('user_id', Auth::user()->id)->select('interest_id')->get();
        $existingInterestsIds = [];

        foreach($existingInterests as $existingInterest) {
            $existingInterestsIds[] = $existingInterest->interest_id;
        }
        
        $tags = Interest::whereRaw('name LIKE ?', ["%$searchString%"])->whereNotIn('id', $existingInterestsIds)->get();
        return $tags;
    }

    public static function updateInterests($data) {
        $existingInterests = UserInterest::where('user_id', Auth::user()->id)->select('interest_id')->get();
        $oldInterests = [];
        foreach($existingInterests as $existingInterest) {
            $oldInterests[] = $existingInterest->interest_id;
        }

        $newInterests = [];
        foreach($data['interests'] as $interest) {
            $newInterests[] = $interest['id'];
        }

        $interestToAdd = array_diff($newInterests, $oldInterests);
        $interestToRemove = array_diff($oldInterests, $newInterests);
        foreach($interestToAdd as $key => $interest_id) {
            $UserInterest = new UserInterest();
            $UserInterest->user_id = Auth::user()->id;
            $UserInterest->interest_id = $interest_id;
            $UserInterest->save();
        }
        
        foreach($interestToRemove as $key => $interest_id) {
            $oldUserInterest = UserInterest::where('interest_id', $interest_id)->where('user_id', Auth::user()->id)->get()->first();
            $oldUserInterest->delete();
        }

        return UserInterest::getAllByUserId();
    }

    public static function getAllByUserId() {
        $userInterests = UserInterest::where('user_id', Auth::user()->id)->with('interest')->get();
        $interests = [];
        foreach($userInterests as $userInterest) {
                $interests[] = $userInterest->interests;
        }

        return $interests;
    }
}