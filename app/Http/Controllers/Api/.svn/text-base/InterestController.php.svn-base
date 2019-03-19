<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;

use App;
use App\Models\Interest;
use Input;
use Lang;

class InterestController extends BaseController
{
    public function index() {
        $interests = Interest::all();
        return $interests;
    }

    public function show($slug) {
    }

    public function store() {
        $response = new \stdClass();
        $newInterest = Interest::add(Input::all());
        
        if($newInterest) {
            $response->new = $newInterest;
            $response->messageType = 'success';
            $response->message = 'Interest added.';
        } else {
            $response->new = false;
            $response->messageType = 'danger';
            $response->message = Lang::get('messages.admin.addError');
        }
        
        return response()->json($response);
    }

    public function update($id) {
        $key = Input::get('key');
        $value = Input::get('value');
        $interest = Interest::updateField($id, Input::all());

        $response = new \stdClass();
        $response->new = $interest;
        $response->messageType = 'success';
        $response->message = 'Interest updated.';
        
        return response()->json($response);
    }

    public function destroy($id) {
        $response = new \stdClass();
        $deletedInterest = Interest::destroy($id);
        if($deletedInterest) {
            $response->messageType = 'success';
            $response->message = 'Interest deleted.'; 
        } else {
            $response->new = false;
            $response->messageType = 'danger';
            $response->message = Lang::get('messages.admin.addError');
        }
        return response()->json($response);
    }
}