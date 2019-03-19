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
use App\Models\Interest;
use App\Models\UserInterest;

class UserInterestController extends MasterController
{
  	public function reorder() {
        $execute = UserInterest::reorder(Input::all());
    }

    public function index() {
        $searchString = Input::get('searchString');
        $unassignedInterests = UserInterest::getAllUnassigned($searchString);
        
        return response()->json($unassignedInterests->toArray());
    }

    public function store() {
        UserInterest::updateInterests(Input::all());
        
        $response = new \stdClass();
        $response->messageType = 'success';
        $response->new = UserInterest::getAllByUserId();
        $response->message = Lang::get('messages.interestsUpdated');
        
        return response()->json($response);
    }

    public function destroy($id){
        $execute = UserInterest::remove($id);
        $success = "Colecție ștearsă.";
        $error = "A fost întâmpinată o problemă. Vă rugăm notificați administratorul.";
        return $this->response($execute, $success ,$error);
                
    }

    public function interest() {
        if(Input::get('ids')) {
            $ids = explode(',', Input::get('ids'));
            $tags = Interest::whereIn('id', $ids)->get();
            return $tags;
        } else {
            $searchString = Input::get('searchString');
            $tags = Interest::whereRaw('name LIKE ?', ["%$searchString%"])->get();
            
            return $tags;
        }
    }


}