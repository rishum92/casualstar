<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Carbon\Carbon;
use Input;
use Image;
use Auth;
use Lang;
use Hash;
use Session;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Photo;
use App\Models\PrivatePhoto;
use App\Models\UserInterest;
use App\Models\Wink;
use App\Models\Online;
use App\Models\Tribute;
use App\Models\DonationAttempt;
use App\Models\Chat;
use Geotools;
use DB;
use App\competition_user;

class CompetitionUserController extends Controller
{
    public function index() 
    {
	 	$user = competition_user::getdata();
	    return json_encode($user);
	}
	// }

 //    public function supersubs() {
 //        $page = Input::get('page');
 //        $perPage = Input::get('perPage');
 //        if(Auth::user()->gender == 'female' && Auth::user()->verify_check != 'VERIFIED') {
 //            $supersubs = [];
 //            $count = 0;
 //        } else {
 //            $supersubs = User::selectRaw('users.*')
 //                            ->selectRaw('(SELECT COUNT(tributes.id) FROM tributes WHERE tributes.user_id = users.id) as tributes_count')
 //                            ->selectRaw('(SELECT COUNT(activities.id) FROM activities WHERE activities.user_id = users.id) as activity_count')
 //                            // ->selectRaw('(SELECT COUNT(winks.id) FROM winks WHERE winks.by_user_id = users.id) as winks_count')
 //                            ->orderBy('tributes_count', 'DESC')
 //                            ->orderBy('activity_count', 'DESC')
 //                            // ->orderBy('winks_count', 'DESC')
 //                            ->where('status', 1)
 //                            ->where('title', 'USER')
 //                            ->where('gender', 'male')
 //                            ->with('lastLogin')
 //                            ->limit($perPage)->skip($page * $perPage - $perPage)
 //                            ->get();
 //            foreach($supersubs as $supersub) {
 //                $supersub->online = Online::getOnline($supersub->id) != null;
 //                if($supersub->lastLogin != null) {
 //                    $supersub->lastLogin->lastLogin = $supersub->lastLogin->created_at->diffForHumans();
 //                }
 //            }
 //            $count = User::where('status', 1)->where('gender', 'male')->count();
 //        }

 //        $data = new \stdClass;
 //        $data->supersubs = $supersubs;
 //        $data->count = $count;

 //        return $this->response($data, '', '');
 //    }

 //    public function deleteMessage() {
 //        $deletedChat = Chat::deleteMessage(Input::all());

 //        return $this->response(true, 'Message deleted.', 'There has been a problem deleting your message.');
 //    }

 //    public function deleteChat() {
 //        $deletedChat = Chat::deleteChat(Input::all());

 //        return $this->response(true, 'Chat deleted.', 'There has been a problem deleting the chat.');
 //    }

 //    public function browse() {
 //        Session::put('filters', Input::all());
 //        $page = Input::get('page');
 //        $perPage = Input::get('perPage');
 //        $lat = Auth::user()->lat;
 //        $lng = Auth::user()->lng;
 //        $user = Auth::user();
	// 	// DB::enableQueryLog();
 //        $haversine = "(3959 * acos(cos(radians(" . $user->lat . ")) 
 //                     * cos(radians(lat))    
 //                     * cos(radians(lng) 
 //                     - radians(" . $user->lng . ")) 
 //                     + sin(radians(" . $user->lat . ")) 
 //                     * sin(radians(lat))))";

 //        $count = User::select('id')->selectRaw("cast({$haversine} as decimal(10,2)) AS distance")->where('id', '!=', $user->id)->where('status', '1')->where('title', 'USER')->whereNotNull('username');
 //        $users = User::select('username', 'img', 'location', 'gender', 'verify_check')->selectRaw("TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age, cast({$haversine} as decimal(10,2)) AS distance")->where('id', '!=', $user->id)->where('status', '1')->where('title', 'USER')->whereNotNull('username');

	// 	if(Input::get('withAllGender') == "false") {
	// 		if(Input::has('distance'))
	// 		{
	// 			$radius = Input::get('distance');
	// 			$users = $users->whereRaw("{$haversine} < ?", [$radius]);
	// 			$count = $count->whereRaw("{$haversine} < ?", [$radius]);
	// 		}
	// 	}
		
 //        if(Input::get('userText') != "" && Input::get('userText') != null) {
 //            $users = $users->where("username","LIKE",Input::get('userText')."%");
 //            $count = $count->where("username","LIKE",Input::get('userText')."%");
 //        }
		
	// 	if($user->gender == 'male') {
	// 		$users = $users->where('gender', 'female');
	// 		$count = $count->where('gender', 'female');
	// 	}

	// 	if($user->gender == 'female') {
	// 		$users = $users->where('gender', 'male');
	// 		$count = $count->where('gender', 'male');
	// 	}

 //        if(Input::get('withImagesOnly') == "true") {
 //            $users = $users->whereNotNull('img');
 //            $count = $count->whereNotNull('img');
 //        }
		
        
 //        $currentDate = date("Y-m-d");

 //        if(Input::get('minAge')) {
 //            $dobYear = explode('-', $currentDate)[0] - Input::get('minAge');
 //            $users = $users->whereDate('dob', '<=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
 //            $count = $count->whereDate('dob', '<=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
 //        }

 //        if(Input::get('maxAge')) {
 //            $dobYear = explode('-', $currentDate)[0] - Input::get('maxAge') - 1;
 //            $users = $users->whereDate('dob', '>=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
 //            $count = $count->whereDate('dob', '>=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
 //        }

 //        if(Input::get('lookingFor')) {
 //            $users = $users->whereHas('interests', function($query)
 //            {
 //                $query->whereIn('interest_id', explode(',', Input::get('lookingFor')));
 //            });
 //            $count = $count->whereHas('interests', function($query)
 //            {
 //                $query->whereIn('interest_id', explode(',', Input::get('lookingFor')));
 //            });
 //        }

 //        if(Input::get('sortBy') == 'created_at') {
 //            $users = $users->orderBy(Input::get('sortBy'), 'DESC');
 //        } elseif(Input::get('sortBy') == 'distance') {
 //            $users = $users->orderBy(Input::get('sortBy'), 'ASC')->orderBy('username', 'ASC');
 //        }

 //        if(Input::get('onlineNow') == 'true') {
 //            $onlineUsers = Online::getOnlineUsers();
 //            $onlineIds = [];
 //            foreach($onlineUsers as $user) {
 //                $onlineIds[] = $user['id'];
 //            }

 //            $users = $users->whereIn('id', $onlineIds);
 //            $count = $count->whereIn('id', $onlineIds);
 //        }


 //        $users = $users->limit($perPage)->skip($page * $perPage - $perPage)->get();
 //        $count = $count->count();

		
 //        if(Input::get('onlineNow') == 'true') {
 //            foreach($users as $key => $user) {
 //                $users[$key]->online = true;
 //            }
 //        }

 //        $data = new \stdClass;
 //        // $qry = DB::getQueryLog();
 //        $data->users = $users;
 //        $data->count = $count;
	// 	// $data->qry = $qry;
 //        return $this->response($data, $users, $count);

 //    }

 //    public function favorites() {
 //        $user = User::where('id', Auth::user()->id)->with(['favorites'=>function($query) {
 //            $page = Input::get('page');
 //            $perPage = Input::get('perPage');
 //            return $query->where('status', '1')->selectRaw("username, location, img, gender, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age")->limit($perPage)->skip($page * $perPage - $perPage)->orderBy('favorites.created_at', 'DESC');
 //        }])->get()->first();

 //        $favorites = $user->favorites;
 //        $count = User::where('id', Auth::user()->id)->with('favorites')->get()->first()->favorites()->count();
        
 //        foreach($favorites as $key => $user) {
 //            $online = Online::getOnline($user->id);
 //            //$online = 1;
 //            $favorites[$key]->online = $online;
 //        }

 //        $data = new \stdClass;
 //        $data->favorites = $favorites;
 //        $data->count = $count;

 //        return $this->response($data, $favorites ,$count);
 //    }

 //    public function show($username) {
 //    	echo "success";die;
 //        $user = User::select('id', 'username', 'img', 'description', 'gender', 'location', 'paypal_url', 'cashme_url','alt_url','verify_img', 'verify_check', 'text_notes', 'verify_created_at','social','twit_enable','twit_private_enable','twit_limit','twit_private_limit')->selectRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age')->with('photos')->with('privatephotos')->with('interests')->where('username', $username)->get()->first();
 //        unset($user->id);
        
 //        if($isFavorite = Favorite::where('user_id', Auth::user()->id)->where('liked_user_id', $user->id)->get()->first()) {
 //            $user->favorite = true;
 //        } else {
 //            $user->favorite = false;
 //        }

 //        if($isWinked = Wink::where('user_id', $user->id)->where('by_user_id', Auth::user()->id)->where('replied', 0)->orderBy('created_at', 'DESC')->first()) {
 //            if($isWinked->replied == 0) {
 //                $user->winked = true;
 //            } else {
 //                $user->winked = false;
 //            }
 //        } else {
 //            $user->winked = false;
 //        }

 //        return $user;
 //    }

 //    public function getById($id) {
 //        $user = User::find($id);

 //        return $user;
 //    }

 //    public function addProfilePhoto() {
 //        $data = Input::all();
 //        $user = User::find(Auth::user()->id);

 //        $profilePhoto = $data['file'];
 //        $x = $data['crop']['x'];
 //        $y = $data['crop']['y'];
 //        $width = $data['crop']['width'];
 //        $height = $data['crop']['height'];
 //        $rotate = $data['crop']['rotate'];
 //        if(array_key_exists('file', $data)) {
 //            if (!file_exists('img/users/' . $user->username)) {
 //                mkdir('img/users/' . $user->username, 0777, true);
 //            }

 //            if (!file_exists('img/users/' . $user->username . '/previews')) {
 //                mkdir('img/users/' . $user->username . '/previews', 0777, true);
 //            }

 //            if (!file_exists('img/users/' . $user->username . '/chat')) {
 //                mkdir('img/users/' . $user->username . '/chat', 0777, true);
 //            }
            
 //            $ext = explode('/', $profilePhoto->getMimeType());

 //            if($ext[0] == 'image') {
 //                $imageInfo = getimagesize($profilePhoto);
 //                if($ext[1] == 'jpeg' || $ext[1] == 'png' || $ext[1] == 'gif') {
 //                    if($ext[1] == 'jpeg') {
 //                        $ext = '.jpg';
 //                    } else {
 //                        $ext = '.' . $ext[1];
 //                    }
 //                } else {
 //                    return false;
 //                }
 //            } else {
 //                return false;
 //            }

 //            if($user->img) {
 //                if(file_exists('img/users/' . $user->username . '/' . $user->img)) {
 //                    unlink('img/users/' . $user->username . '/' . $user->img);
 //                }
 //                if(file_exists('img/users/' . $user->username . '/chat/' . $user->img)) {
 //                    unlink('img/users/' . $user->username . '/chat/' . $user->img);
 //                }
 //                if(file_exists('img/users/' . $user->username . '/previews/' . $user->img)) {
 //                    unlink('img/users/' . $user->username . '/previews/' . $user->img);
 //                }
 //            }

 //            $profilePhotoFile = uniqid() . $ext;
 //            $profilePhoto->move('img/users/' . $user->username, $profilePhotoFile);
 //            $profilePhotoChat = Image::make(public_path('img/users/' . $user->username . '/' . $profilePhotoFile));
 //            $profilePhotoChat->rotate(-$rotate);
 //            $profilePhotoChat->crop((int) $width, (int) $height, (int) $x, (int) $y);
 //            $profilePhotoChat->resize(40, 40, function ($constraint) {
 //                $constraint->aspectRatio();
 //            });
 //            $profilePhotoChat->save('img/users/' . $user->username . '/chat/' . $profilePhotoFile);

 //            $profilePhotoPreview = Image::make(public_path('img/users/' . $user->username . '/' . $profilePhotoFile));
 //            $profilePhotoPreview->rotate(-$rotate);
 //            $profilePhotoPreview->crop((int) $width, (int) $height, (int) $x, (int) $y);
 //            $profilePhotoPreview->resize(220, 220, function ($constraint) {
 //                $constraint->aspectRatio();
 //            });
 //            $profilePhotoPreview->save('img/users/' . $user->username . '/previews/' . $profilePhotoFile);



 //            $profilePhotoImage = Image::make(public_path('img/users/' . $user->username . '/' . $profilePhotoFile));
 //            $profilePhotoImage->rotate(-$rotate);
 //            $profilePhotoImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
 //            $profilePhotoImage->resize(900, 900 , function ($constraint) {
 //                $constraint->aspectRatio();
 //            });
 //            $profilePhotoImage->save();

 //            $user->img = $profilePhotoFile;
 //            $user->save();

 //            $user = User::with('photos')->with('interests')->where('id', Auth::user()->id)->get()->first();
 //            return $this->response($user, Lang::get('messages.profilePhotoUpdated'), Lang::get('errorMsg'));
 //        } else {
 //            return false;
 //        }
 //    }

 //    public function addCoverPhoto() {
 //        $data = Input::all();
 //        $user = User::find(Auth::user()->id);

 //        $profilePhoto = $data['file'];
 //        $x = $data['crop']['x'];
 //        $y = $data['crop']['y'];
 //        $width = $data['crop']['width'];
 //        $height = $data['crop']['height'];
 //        $rotate = $data['crop']['rotate'];

 //        if(array_key_exists('file', $data)) {
 //            if (!file_exists('img/users/' . $user->id)) {
 //                mkdir('img/users/' . $user->id, 0777, true);
 //            }

 //            if (!file_exists('img/users/' . $user->id . '/previews')) {
 //                mkdir('img/users/' . $user->id . '/previews', 0777, true);
 //            }
            
 //            $ext = explode('/', $profilePhoto->getMimeType());

 //            if($ext[0] == 'image') {
 //                $imageInfo = getimagesize($profilePhoto);
 //                if($ext[1] == 'jpeg' || $ext[1] == 'png' || $ext[1] == 'gif') {
 //                    if($ext[1] == 'jpeg') {
 //                        $ext = '.jpg';
 //                    } else {
 //                        $ext = '.' . $ext[1];
 //                    }
 //                } else {
 //                    return false;
 //                }
 //            } else {
 //                return false;
 //            }

 //            $profilePhotoFile = uniqid() . $ext;
 //            $profilePhoto->move('img/users/' . $user->id, $profilePhotoFile);
 //            $profilePhotoImage = Image::make('img/users/' . $user->id . '/' . $profilePhotoFile);
 //            $profilePhotoImage->rotate(-$rotate);
 //            $profilePhotoImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
 //            $profilePhotoImage->resize(1600, null, function ($constraint) {
 //                $constraint->aspectRatio();
 //            });
 //            $profilePhotoImage->save();

 //            $user->cover = $profilePhotoFile;
 //            $user->save();

 //            $user = User::with('photos')->with('interests')->where('id', Auth::user()->id)->get()->first();
 //            return $this->response($user, Lang::get('messages.coverPhotoUpdated'), Lang::get('errorMsg'));
 //            return $user;
 //        } else {
 //            return false;
 //        }
 //    }

 //    public function getViews() {
 //        $user = User::where('id', Auth::user()->id)->with(['views'=>function($query) {
 //            $page = Input::get('page');
 //            $perPage = Input::get('perPage');
 //            return $query->where('status','1')->withTimestamps()->limit($perPage)->skip($page * $perPage-$perPage)->orderBy('profile_views.updated_at', 'DESC');
 //        }])->get()->first();

 //        $views = $user->views;
 //        foreach($views as $key => $user) {
 //            $views[$key]->viewDate = $user->pivot->updated_at;
 //            $online = Online::getOnline($user->id);
 //            //$online=1;
 //            if(!is_null($online)) {
 //                $views[$key]->online = true; 
 //            }
 //        }
 //        $count = User::where('id', Auth::user()->id)->with('views')->get()->first()->views()->count();
        
 //        $data = new \stdClass;
 //        $data->views = $views;
 //        $data->count = $count;


 //        return $this->response($data, $views ,$count);
 //    }

 //    public function getWinks() {
 //        $user = User::where('id', Auth::user()->id)->with(['winks'=>function($query) {
 //                $page = Input::get('page');
 //                $perPage = Input::get('perPage');
 //                return $query->where('status','1')->limit($perPage)->skip($page * $perPage - $perPage)->orderBy('winks.created_at', 'DESC');
 //        }])->get()->first();

 //        $winks = $user->winks;
 //        foreach($winks as $key => $user) {
 //            $online = Online::getOnline($user->id);
 //            //$online=1;
 //            if(!is_null($online)) {
 //                $winks[$key]->online = true; 
 //            }
 //        }
 //        $count = User::where('id', Auth::user()->id)->with('winks')->get()->first()->winks()->count();
        
 //        $data = new \stdClass;
 //        $data->winks = $winks;
 //        $data->count = $count;

 //        return $this->response($data, $winks ,$count);
 //    }

 //    public function getDonationAttempts() {
 //        $user = User::where('id', Auth::user()->id)->with(['donationAttempts'=>function($query) {
 //            $page = Input::get('pageDonationAttempts');
 //            $perPage = Input::get('perPageDonationAttempts');
 //            return $query->where('status','1')->withTimestamps()->limit($perPage)->skip($page * $perPage-$perPage)->orderBy('donation_attempts.created_at', 'DESC');
 //        }])->get()->first();

 //        $donationAttempts = $user->donationAttempts;
 //        foreach($donationAttempts as $key => $user) {
 //            $donationAttempts[$key]->attemptDate = $user->pivot->created_at;
 //            $online = Online::getOnline($user->id);
 //            if(!is_null($online)) {
 //                $donationAttempts[$key]->online = true; 
 //            }
 //        }

 //        $count = User::where('id', Auth::user()->id)->with('donationAttempts')->get()->first()->donationAttempts()->count();
        
 //        $data = new \stdClass;
 //        $data->donationAttempts = $donationAttempts;
 //        $data->count = $count;

 //        return $this->response($data, $donationAttempts ,$count);
 //    }

 //    public function update($id){
 //        $error = Lang::get('messages.error');
 //        if(Input::get('key') == 'title' || Input::get('key') == 'username' || Input::get('key') == 'gender' || Input::get('key') == 'id') {
 //            return $this->response(false, '', $error);
 //        } else {
 //            $execute = User::updateField(Auth::user()->id, Input::all());
 //            $success = Lang::get('messages.updated', ['field' => ucfirst(Input::get('key'))]);

 //            if(Input::get('key') == 'alt_url' && Input::get('value') == 1) {
 //                $success = "Another method Enabled. See profile page/ donate for changes.";
 //            } elseif(Input::get('key') == 'alt_url' && Input::get('value') == 0) {
 //                $success = "Option has been disabled.";
 //            }
            
 //            return $this->response($execute, $success ,$error);
 //        }
 //    }

 //    public function wink($username) {
 //        $user = User::where('username', $username)->first();
 //        $winkBack = Wink::where('by_user_id', $user->id)->where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->first();
 //        if($winkBack) {
 //            $winkBack->replied = 1;
 //            $winkBack->save();
 //        }
        
 //        $winked = Wink::where('by_user_id', Auth::user()->id)->where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();
        
 //        if($winked) {
 //            if($winked->replied == 0) {
 //                return $this->response(false, '' , Lang::get('messages.alreadyWinked'));
 //            }
 //        }

 //        $wink = new Wink();
 //        $wink->user_id = $user->id;
 //        $wink->seen = false;
 //        $wink->by_user_id = Auth::user()->id;
 //        $wink->replied = 0;
 //        $wink->save();

 //        return $this->response($wink, Lang::get('messages.youWinked'), '');
 //    }

 //    public function updateLocation() {
 //        $user = Auth::user();
 //        $user->lat = Input::get('lat');
 //        $user->lng = Input::get('lng');
 //        $user->location = Input::get('location');
 //        $user->save();
        
 //        $user = User::select('id', 'username', 'img', 'description', 'gender', 'location','lat','lng', 'paypal_url', 'cashme_url', 'alt_url', 'email', 'remember_token','social','twit_enable','twit_private_enable','twit_limit','twit_private_limit')->selectRaw("TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age")->with('photos')->with('interests')->with('winks')->with('views')->where('id', Auth::user()->id)->get()->first();

 //        return $this->response($user, Lang::get('messages.locationUpdated'), '');
 //    }

 //    public function updateEmail() {
 //        $existing = User::where('email', Input::get('email'))->first();
        
 //        if($existing) {
 //            return $this->response(false, '', Lang::get('messages.emailInUse'));
 //        } else {
 //            $user = User::find(Auth::user()->id);   
 //            $user->email = Input::get('email');
 //            $user->save();

 //            return $this->response($user, Lang::get('messages.emailUpdated'), '');
 //        }
 //    }

 //    public function changePassword() {
 //        $old_password = Input::get('old_password');
 //        $credentials = array(
 //                'email' => Auth::user()->email,
 //                'password' => Input::get('old_password')
 //                );

 //        if(Input::get('password') == Input::get('old_password')) {
 //                return $this->response(false, '', Lang::get('messages.passwordsIdentical'));
 //        }

 //        if(Auth::validate($credentials)) {
 //            $user = User::find(Auth::user()->id);
 //            if(Input::get('password') == Input::get('password_confirmation')) {
 //                $user->password = Hash::make(Input::get('password'));
 //                $user->save();
 //                return $this->response($user, Lang::get('messages.passwordUpdated'), '');
 //            } else {
 //                return $this->response(false, '', Lang::get('messages.passwordNotMatched'));
 //            }
 //        } else {
 //            return $this->response(false, '', Lang::get('messages.currentPasswordError'));
 //        }
 //    }

 //    public function deleteProfilePhoto() {
 //        $user = User::find(Auth::user()->id);
 //        unlink('img/users/' . $user->username . '/' . $user->img);
 //        unlink('img/users/' . $user->username . '/chat/' . $user->img);
 //        unlink('img/users/' . $user->username . '/previews/' . $user->img);
 //        $user->img = NULL;
 //        $user->save();

 //        return $this->response($user, 'Profile photo removed.', 'Profile photo could not be removed.');
 //    }

 //    public function donate($username) {
 //        $user = User::where('username', $username)->first();
 //        if(Auth::user()->id != $user->id) {
 //            if(!is_null(Input::get('donate')) && (isset($user->paypal_url) || isset($user->cashme_url) || isset($user->cashme_url_uk))) {
 //                $donation = new DonationAttempt();
 //                $donation->by_user_id = Auth::user()->id;
 //                $donation->user_id = $user->id;
 //                $donation->method = Input::get('method');
 //                $donation->seen = 0;
 //                $donation->save();

 //                $tribute = new Tribute();
 //                $tribute->type = 'DONATE';
 //                $tribute->user_id = Auth::user()->id;
 //                $tribute->to_user_id = $user->id;
 //                $tribute->save();
 //            }
 //        }
 //    }
	
	// public function addSelfiePhoto() {
 //        $data = Input::all();
 //        $user = User::find(Auth::user()->id);

 //        $profilePhoto = $data['file'];
 //        $x = $data['crop']['x'];
 //        $y = $data['crop']['y'];
 //        $width = $data['crop']['width'];
 //        $height = $data['crop']['height'];
 //        $rotate = $data['crop']['rotate'];
 //        if(array_key_exists('file', $data)) {
 //            if (!file_exists('img/Verified/users/' . $user->username)) {
 //                mkdir('img/Verified/users/' . $user->username, 0777, true);
 //            }

 //            $ext = explode('/', $profilePhoto->getMimeType());

 //            if($ext[0] == 'image') {
 //                $imageInfo = getimagesize($profilePhoto);
 //                if($ext[1] == 'jpeg' || $ext[1] == 'png' || $ext[1] == 'gif') {
 //                    if($ext[1] == 'jpeg') {
 //                        $ext = '.jpg';
 //                    } else {
 //                        $ext = '.' . $ext[1];
 //                    }
 //                } else {
 //                    return false;
 //                }
 //            } else {
 //                return false;
 //            }

 //            if($user->verify_img) {
 //                if(file_exists('img/Verified/users/' . $user->username . '/' . $user->verify_img)) {
 //                    unlink('img/Verified/users/' . $user->username . '/' . $user->verify_img);
 //                }
 //            }

 //            $profilePhotoFile = uniqid() . $ext;
	// 		$profilePhoto->move('img/Verified/users/' . $user->username, $profilePhotoFile);
 //            $user->verify_img = $profilePhotoFile;
 //            $user->uploaded_at = date("Y-m-d H:i:s");
 //            $user->verify_check = 'PENDING';
 //            $user->save();

 //            $user = User::where('id', Auth::user()->id)->get()->first();
 //            return $this->response($user, Lang::get('messages.selfieUpload'), Lang::get('errorMsg'));
 //        } else {
 //            return false;
 //        }
 //    }

 //    public function profile_comment() {
 //        $data = Input::all();
 //        $user = User::find(Auth::user()->id);
 //        echo '<pre>';print_r($data);
 //        echo $user;exit;
 //    }
}
