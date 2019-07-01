<?php

namespace App\Http\Controllers\Api;

use App\Models\BannerAdResource;
use Illuminate\Routing\Controller as BaseController;

use App;
use App\Models\BannerAd;
use App\Models\BannerAdRequest;
use Input;
use Lang;
use App\Models\User;
use Mail;
use Image;

class BannerAdRequestController extends BaseController
{
    public function index() {
        $bannerAdRequests = BannerAdRequest::all();
        return $bannerAdRequests;
    }

    public function show($slug) {
    }

    public function store() {
        $response = new \stdClass();
        $selectedDays = Input::get('selectedDays');
        if(!is_array($selectedDays) || count($selectedDays) == 0) {
            $response->new = false;
            $response->messageType = 'warning';
            $response->message = 'No days were selected. Restarting booking process..';
            return response()->json($response);
        }
        $newBannerAdRequest = null;
        $daysAreNotBooked = true;
        $selectedDaysCount = 0;
        foreach($selectedDays as $selectedDay) {
            $existingBannerAd = BannerAd::where('day', $selectedDay)->exists();
            if($existingBannerAd) {
                $daysAreNotBooked = false;
                $response->new = false;
                $response->messageType = 'warning';
                $response->message = 'One or more of the selected days have already been booked. Restarting booking process..';
                return $response;
            } else {
                $selectedDaysCount++;
            }
        }

        if($daysAreNotBooked && $selectedDaysCount > 0) {
            $type = Input::get('type');
            $file = Input::file('file');

            if($type == 'video') {
                $fileUploaded = $this->uploadVideo($file);
                if(!$fileUploaded) {
                    $response->new = false;
                    $response->messageType = 'warning';
                    $response->message = 'Invalid file uploaded. Restarting booking process..';

                    return response()->json($response);
                }
                $newBannerAdRequest = new BannerAdRequest();
                $newBannerAdRequest->user_id = \Auth::user()->id;
                $newBannerAdRequest->status = 'review';
                $newBannerAdRequest->type = $type;
                $newBannerAdRequest->extra_promotions = Input::get('extra_promotions') == 'true';
                $newBannerAdRequest->save();
                $this->createBannerAdResource($newBannerAdRequest->id, $fileUploaded);
            } else {
                $newBannerAdRequest = new BannerAdRequest();
                $newBannerAdRequest->user_id = \Auth::user()->id;
                $newBannerAdRequest->status = 'review';
                $newBannerAdRequest->type = $type;
                $newBannerAdRequest->extra_promotions = Input::get('extra_promotions') == 'true';
                $newBannerAdRequest->save();
                if(isset($file['file1'])) {
                    $fileUploaded = $this->uploadPhoto($file['file1'], $selectedDays[0]);
                    $this->cropAndResizePhoto($fileUploaded, Input::get('file1CropData'));
                    $this->createBannerAdResource($newBannerAdRequest->id, $fileUploaded);
                }
                if(isset($file['file2'])) {
                    $fileUploaded = $this->uploadPhoto($file['file2'], $selectedDays[0]);
                    $this->cropAndResizePhoto($fileUploaded, Input::get('file2CropData'));
                    $this->createBannerAdResource($newBannerAdRequest->id, $fileUploaded);
                }
                if(isset($file['file3'])) {
                    $fileUploaded = $this->uploadPhoto($file['file3'], $selectedDays[0]);
                    $this->cropAndResizePhoto($fileUploaded, Input::get('file3CropData'));
                    $this->createBannerAdResource($newBannerAdRequest->id, $fileUploaded);
                }
                if(isset($file['file4'])) {
                    $fileUploaded = $this->uploadPhoto($file['file4'], $selectedDays[0]);
                    $this->cropAndResizePhoto($fileUploaded, Input::get('file4CropData'));
                    $this->createBannerAdResource($newBannerAdRequest->id, $fileUploaded);
                }
            }

            foreach($selectedDays as $selectedDay) {
                $existingBannerAd = BannerAd::where('day', $selectedDay)->exists();
                if(!$existingBannerAd) {
                    $newBannerAd = new BannerAd();
                    $newBannerAd->banner_ad_request_id = $newBannerAdRequest->id;
                    $newBannerAd->day = $selectedDay;
                    $newBannerAd->save();
                }
            }
            if($newBannerAdRequest) {
                $response->new = $newBannerAdRequest;
                $response->messageType = 'success';
                $response->message = 'Banner ad request created!';

                $user = User::find(\Auth::user()->id);
                $toEmail = $user->email;
                $subject = 'Banner ad request received';
                $name = 'CasualStar';
                $fromEmail = 'casualstar.uk.info@gmail.com';
                Mail::send('emails.bannerAdRequestReceived', ['bannerAdRequest' => $newBannerAdRequest], function($email) use($name, $fromEmail, $toEmail, $subject) {
                    $email->from($fromEmail, $name)->to($toEmail)->cc($fromEmail)->subject($subject);
                });
            } else {
                $response->new = false;
                $response->messageType = 'warning';
                $response->message = 'One or more of the selected days have already been booked. Restarting booking process..';
            }
        }

        return response()->json($response);
    }

    private function cropAndResizePhoto($filename, $data) {
        $x = $data['x'];
        $y = $data['y'];
        $width = $data['width'];
        $height = $data['height'];
        $rotate = $data['rotate'];

        $photo = Image::make(public_path('banner-ads-resources/images/' . $filename));
        $photo->rotate(-$rotate);
        $photo->crop((int) $width, (int) $height, (int) $x, (int) $y);
        $photo->resize(1440, 900, function ($constraint) {
            $constraint->aspectRatio();
        });
        $photo->save();

    }

    private function createBannerAdResource($bannerAdRequestId, $uploadedFile) {
        if($uploadedFile) {
            $newBannerAdResource = new BannerAdResource();
            $newBannerAdResource->banner_ad_request_id = $bannerAdRequestId;
            $newBannerAdResource->resource = $uploadedFile;
            $newBannerAdResource->save();

            return $newBannerAdResource;
        }

        return false;
    }

    private function uploadPhoto($file, $prefix) {
        $ext = explode('/', $file->getMimeType());
        if($ext[0] == 'image') {
            $imageInfo = getimagesize($file);
            if($ext[1] == 'jpeg' || $ext[1] == 'png') {
                if($ext[1] == 'jpeg') {
                    $ext = '.jpg';
                } else {
                    $ext = '.' . $ext[1];
                }
                $filename = $prefix . '_' .  uniqid() . $ext;
                $file->move(public_path() . '/banner-ads-resources/images', $filename);
                return $filename;
            }
        } else {
            return false;
        }
    }

    private function uploadVideo($file) {
        $ext = explode('/', $file->getMimeType());
        if($ext[0] == 'video') {
            if($ext[1] == 'mp4' || $ext[1] == 'mov') {
                $filename = uniqid() . '.' . $ext[1];
                $file->move(public_path() . '/banner-ads-resources/videos', $filename);
                return $filename;
            }
        }
        return false;
    }

    public function update($id) {
        $key = Input::get('key');
        $value = Input::get('value');
        $bannerAdRequest = BannerAdRequest::updateField($id, Input::all());
        if($key == 'status' && $value == 'denied') {
            $bannerAds = BannerAd::where('banner_ad_request_id', $bannerAdRequest->id)->get();
            foreach($bannerAds as $bannerAd) {
                $bannerAd->delete();
            }
        }
        $response = new \stdClass();
        $response->new = $bannerAdRequest;
        $response->messageType = 'success';
        $response->message = 'BannerAdRequest updated.';
        
        return response()->json($response);
    }

    public function destroy($id) {
        $response = new \stdClass();
        $deletedBannerAdRequest = BannerAdRequest::destroy($id);
        if($deletedBannerAdRequest) {
            $response->messageType = 'success';
            $response->message = 'BannerAdRequest deleted.'; 
        } else {
            $response->new = false;
            $response->messageType = 'danger';
            $response->message = Lang::get('messages.admin.addError');
        }
        return response()->json($response);
    }

    public function activeBannerAd() {
        $bannerAdRequest = BannerAdRequest::where('status','active')
            ->whereHas('bannerAds', function($q) {
                $q->where('day', '=', date('Y-m-d'));
            })->whereHas('user', function($q) {
                $q->where('status', 1);
            })->first();

        return $bannerAdRequest;
    }
}