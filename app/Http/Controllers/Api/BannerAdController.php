<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

use App;
use App\Models\BannerAd;
use Input;
use Lang;

class BannerAdController extends BaseController
{
    public function index() {
        $bannerAds = BannerAd::all();
        return $bannerAds;
    }

    public function update($id) {
        $key = Input::get('key');
        $value = Input::get('value');
        $bannerAd = BannerAd::updateField($id, Input::all());

        $response = new \stdClass();
        $response->new = $bannerAd;
        $response->messageType = 'success';
        $response->message = 'BannerAd updated.';
        
        return response()->json($response);
    }

    public function destroy($id) {
        $response = new \stdClass();
        $deletedBannerAd = BannerAd::destroy($id);
        if($deletedBannerAd) {
            $response->messageType = 'success';
            $response->message = 'BannerAd deleted.'; 
        } else {
            $response->new = false;
            $response->messageType = 'danger';
            $response->message = Lang::get('messages.admin.addError');
        }
        return response()->json($response);
    }
}