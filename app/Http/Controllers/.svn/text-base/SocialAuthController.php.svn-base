<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Input;
use Auth;
use Hash;
use Image;
use File;
use Lang;
use App\User;
use App\Models\User as UserModel;
use App\Models\UserProvider;
use App\Models\serviceProvider;
use App\Models\Activity;
use Session;
use Carbon\Carbon;
use Laravel\Socialite\Contracts\Factory as Socialite;  

class SocialAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct(Socialite $socialite, $email_addr=null){
       $this->socialite = $socialite;
    }

    public function getSocialAuth($provider=null)
    {
        if(!config("services.$provider")) abort('404');
		
		if($provider == "twitter"){
			try{
				Session::put('Twit_verification', false);
				return $this->socialite->with($provider)->redirect();
			}catch(Exception $e){
				abort('404');
			}
/* 			$rules = array(
				'email'    => 'required',
				'password' => 'required|min:3'
			);

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.loginError'))->with('toggleLogin', true)->with('username', Input::get('email'));
			} else {
				if(strpos(Input::get('email'), '@') > 0) {
					session(['email' => Input::get('email')]);
					return $this->socialite->with($provider)->redirect();
				} else {
					return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.loginError'))->with('toggleLogin', true)->with('username', Input::get('email'));
				}
			} */
		}else{
			return $this->socialite->with($provider)->fields([
					'first_name', 'last_name', 'email', 'gender', 'birthday'
				])->scopes([
					'email', 'user_birthday'
				])->redirect();
		}
    }

    public function getSocialAuthCallback($provider=null)
    {
		if($provider == 'twitter1'){
			try{
			$user_credential = $this->socialite->with($provider)->user();
			if(count($user_credential) > 0) {
				if(empty($user_credential->email) || $user_credential->email == "" || $user_credential->email == null){
					Session::flush();
					return redirect()->route('index')->with('messageType', 'danger')->with('message', "Twitter Email Authentication Failed.");
				}else{
					$check_user = UserModel::where('email', $user_credential->email)->where('social',0)->first();
					if($check_user){
						Session::flush();
						return redirect()->route('index')->with('messageType', 'danger')->with('message', "Invalid Authentication Logged In");
					}
				}
				// $email_only = session()->pull('email', $user_credential->email);
				$email_only = $user_credential->email;
				$user_status_id = UserModel::where('email', $email_only)->where('social',1)->where('status',2)->first();
				if($user_status_id){
					UserProvider::where('provider', 'twitter')->where('user_id', $user_status_id->user_id)->delete();
					UserModel::where('email', $email_only)->where('social',1)->where('status',2)->delete();
				}
				
				
				$existing_provider = UserProvider::where('provider', 'twitter')->where('provider_id', $user_credential->user['id_str'])->first();
				
				if($existing_provider) {
					$user = User::find($existing_provider->user_id);
					if($user){
						$userProvider = UserProvider::where('user_id', $existing_provider->user_id)->first();
						$userProvider->email_id = $email_only;
						$userProvider->access_token = $user_credential->token;
						$userProvider->access_token_secret = $user_credential->tokenSecret;
						$userProvider->save();
					}else{
					}
				} else {
					
					$existing_email = UserModel::where('email', $email_only)->where('social',1)->first();
					if($existing_email) {
						$user_check = UserProvider::where('user_id', $existing_email->id)->first();
						// print_r($user_check);return;
						if($user_check){
							if($user_check->provider_id != $user_credential->user['id_str']){
								return redirect()->route('index')->with('messageType', 'danger')->with('message', "Invalid Authentication Logged In");
							}							
						}
					
						$user = User::find($existing_email->user_id);
						if($user){
							$userProvider = new UserProvider();
							$userProvider->email_id = $email_only;
							$userProvider->user_id = $user->id;
							$userProvider->provider_id = $user_credential->user['id_str'];
							$userProvider->provider = 'twitter';
							$userProvider->access_token = $user_credential->token;
							$userProvider->access_token_secret = $user_credential->tokenSecret;
							$userProvider->save();
						}
					}else{
						$newUser = new UserModel();
						$newUser->email = $email_only;
						$newUser->username = $user_credential->nickname;
						$newUser->social = 1;
						$newUser->status = 2;
						$newUser->title = 'USER';
						$newUser->twit_enable = 1;
						$newUser->twit_private_enable = 1;
						$newUser->save();

						$userProvider = new UserProvider();
						$userProvider->user_id = $newUser->id;
						$userProvider->email_id = $newUser->email;
						$userProvider->provider_id = $user_credential->user['id_str'];
						$userProvider->provider = 'twitter';
						$userProvider->access_token = $user_credential->token;
						$userProvider->access_token_secret = $user_credential->tokenSecret;
						$userProvider->save();

						$data = array('email'=>$email_only, 'user_id' => $newUser->id, 'twit_user_data' => $user_credential->nickname);
						return redirect()->route('index')->with('messageType', 'info')->with('message', Lang::get('messages.accountCompletion'))->with('toggleLoginTwitter', false)->with($data);
					}
				}

				if($user) {
					if($user->status == -1) {
						return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.accountLocked'))->with('toggleLogin', false);
					} elseif($user->status == 0) {
						$user->status = 1;
						$user->save();
					}
				}
				
				Auth::login($user);
				// echo "user id ".$user->id;exit;
				
				if(Auth::check()) {

					Session::put('filters', ['distance' => 1000]);
					
					// echo print_r($user);exit;
					if(($user->gender == null || $user->gender == "") || ($user->lng == null || $user->lng == "") || ($user->lat == null || $user->lat == "") && $user->social == 1){
						Auth::logout();
						$data = array('email'=>$email_only, 'user_id' => $user->id);
						return redirect()->route('index')->with('messageType', 'danger')->with('message', 'Empty Details Found in User')->with('toggleLoginTwitter', true)->with($data);
					}
					$loginActivity = new Activity();
					$loginActivity->user_id = Auth::user()->id;
					$loginActivity->activity = 'LOGIN';
					$loginActivity->save();

					return redirect()->route('dashboard')->with('messageType', 'success')->with('message', 'Welcome, ' . $user->username . '!');
				}else{
					return redirect()->back()->with('messageType', 'danger')->with('message', Lang::get('messages.loginServerError'));
				}
			} else {
				return redirect()->back()->with('messageType', 'danger')->with('message', Lang::get('messages.loginServerError'));
			}
			
			}catch(\Exception $e){
				if(Auth::check()){
					Auth::logout();
				}
				$data = array('email'=>$email_only, 'user_id' => $user->id);
				return redirect()->route('index')->with('messageType', 'danger')->with('message', $e->getMessage())->with($data);
			}
		}else if($provider == 'twitter'){
			try{
			$user_credential = $this->socialite->with($provider)->user();
			// echo "<pre>"; print_r($user_credential);exit;
			if(count($user_credential) > 0) {
				// $user_credential->email = "chagkamal.ap@gmail.com";
				if(empty($user_credential->email) || $user_credential->email == "" || $user_credential->email == null){
					Session::flush();
					return redirect()->route('index')->with('messageType', 'danger')->with('message', "Twitter Email Authentication Failed.");
				}else{
					if(Session::get('Twit_verification') == true){
						/* $sProvider = DB::table('user_twit_details')->	insert(['user_id' => $user_credential->user['id_str']); */
						$id = -1;
						$msg = "There is some Problem";
						$msgType = "danger";
						
							
						try{
							// // $msg = \DB::getDatabaseName();
							// /* return redirect()->route('twit.account')->with('reg_twit', 0)->with('post_twit', 1)->with('messageType', 'danger')->with('message', Auth::user()->id); */

							$check_user = UserModel::where('email','=',$user_credential->email)->whereNotIn('id', array(Auth::user()->id))->count();
							$check_provider = UserProvider::where('email_id', $user_credential->email)->whereNotIn('user_id', array(Auth::user()->id))->count();
							$check_twit_details = serviceProvider::where('email_id', $user_credential->email)->whereNotIn('user_id', array(Auth::user()->id))->count();
							
							if($check_user == 0 && $check_provider == 0 && $check_twit_details == 0){
								$id = \DB::table('user_twit_details')->insertGetId(
									[
										'user_id' => Auth::user()->id,
										'email_id' => $user_credential->email, 
										'nickname' => $user_credential->nickname, 
										'provider_id' => $user_credential->user['id_str'], 
										'access_token' => $user_credential->token, 
										'access_token_secret' => $user_credential->tokenSecret, 
									]
								);
								$msg = "Registered Successfully.";
								$msgType = "success";
							}else{
								$msg = "User Already Exists.";
								$msgType = "info";
							}
						}catch(\Exception $e){
							$msg = "Failed to Authenticate";
							$msgType = "danger";
						}
						return redirect()->route('twit.account')->with('reg_twit', 0)->with('post_twit', 1)->with('messageType', $msgType)->with('message', $msg);
					}else{
						/* Session::flush();
						return redirect()->route('index')->with('messageType', 'danger')->with('message', "Invalid Authentication Logged In"); */
					}
					
					// $check_user = UserModel::where('email', $user_credential->email)->where('social',0)->first();
					/* if($check_user){
						Session::flush();
						return redirect()->route('index')->with('messageType', 'danger')->with('message', "Invalid Authentication Logged In");
					} */
				}
				// $email_only = session()->pull('email', $user_credential->email);
				$email_only = $user_credential->email;
				$user_status_id = UserModel::where('email', $email_only)->where('social',1)->where('status',2)->first();
				if($user_status_id){
					UserProvider::where('provider', 'twitter')->where('user_id', $user_status_id->user_id)->delete();
					UserModel::where('email', $email_only)->where('social',1)->where('status',2)->delete();
				}
				
				
				$existing_provider = UserProvider::where('provider', 'twitter')->where('provider_id', $user_credential->user['id_str'])->first();
				
				if($existing_provider) {
					$user = User::find($existing_provider->user_id);
					if($user){
						$userProvider = UserProvider::where('user_id', $existing_provider->user_id)->first();
						$userProvider->email_id = $email_only;
						$userProvider->nickname = $user_credential->nickname;
						$userProvider->access_token = $user_credential->token;
						$userProvider->access_token_secret = $user_credential->tokenSecret;
						$userProvider->save();
					}else{
					}
				} else {
					
					$existing_email = UserModel::where('email', $email_only)->where('social',1)->first();
					if($existing_email) {
						$user_check = UserProvider::where('user_id', $existing_email->id)->first();
						// print_r($user_check);return;
						if($user_check){
							if($user_check->provider_id != $user_credential->user['id_str']){
								return redirect()->route('index')->with('messageType', 'danger')->with('message', "Invalid Authentication Logged In");
							}							
						}
					
						$user = User::find($existing_email->user_id);
						if($user){
							$userProvider = new UserProvider();
							$userProvider->email_id = $email_only;
							$userProvider->nickname = $user_credential->nickname;
							$userProvider->user_id = $user->id;
							$userProvider->provider_id = $user_credential->user['id_str'];
							$userProvider->provider = 'twitter';
							$userProvider->access_token = $user_credential->token;
							$userProvider->access_token_secret = $user_credential->tokenSecret;
							$userProvider->save();
						}
					}else{
						$newUser = new UserModel();
						$newUser->email = $email_only;
						$newUser->username = $user_credential->nickname;
						$newUser->social = 1;
						$newUser->status = 2;
						$newUser->title = 'USER';
						$newUser->twit_enable = 1;
						$newUser->twit_private_enable = 1;
						$newUser->save();

						$userProvider = new UserProvider();
						$userProvider->email_id = $email_only;
						$userProvider->nickname = $user_credential->nickname;
						$userProvider->user_id = $newUser->id;
						$userProvider->provider_id = $user_credential->user['id_str'];
						$userProvider->provider = 'twitter';
						$userProvider->access_token = $user_credential->token;
						$userProvider->access_token_secret = $user_credential->tokenSecret;
						$userProvider->save();

						$data = array('email'=>$email_only, 'user_id' => $newUser->id, 'twit_user_data' => $user_credential->nickname);
						return redirect()->route('index')->with('messageType', 'info')->with('message', Lang::get('messages.accountCompletion'))->with('toggleLoginTwitter', false)->with($data);
					}
				}

				if($user) {
					if($user->status == -1) {
						return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.accountLocked'))->with('toggleLogin', false);
					} elseif($user->status == 0) {
						$user->status = 1;
						$user->save();
					}
				}
				
				Auth::login($user);
				// echo "user id ".$user->id;exit;
				
				if(Auth::check()) {

					Session::put('filters', ['distance' => 1000]);
					
					// echo print_r($user);exit;
					if(($user->gender == null || $user->gender == "") || ($user->lng == null || $user->lng == "") || ($user->lat == null || $user->lat == "") && $user->social == 1){
						Auth::logout();
						// $data = array('email'=>$email_only, 'user_id' => $user->id);
						$data = array('email'=>$email_only, 'user_id' => $user->id, 'twit_user_data' => $user_credential->nickname);
						return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.accountCompletion'))->with('toggleLoginTwitter', true)->with($data);
					}
					
					$loginActivity = new Activity();
					$loginActivity->user_id = Auth::user()->id;
					$loginActivity->activity = 'LOGIN';
					$loginActivity->save();
					
					return redirect()->route('dashboard')->with('messageType', 'success')->with('message', 'Welcome, ' . $user->username . '!');
				}else{
					return redirect()->back()->with('messageType', 'danger')->with('message', Lang::get('messages.loginServerError'));
				}
			} else {
				return redirect()->back()->with('messageType', 'danger')->with('message', Lang::get('messages.loginServerError'));
			}
			
			}catch(\Exception $e){
				if(Auth::check()){
					Auth::logout();
					Session::flush();
				}
				$data = array('email'=>$email_only, 'user_id' => $user->id);
				return redirect()->route('index')->with('messageType', 'danger')->with('message', $e->getMessage())->with($data);
			}
		}else{
			return 'something really went wrong';
		}
    }

    public function checkUsername() {
        $requestedUsername = Input::get('username');
        $existingUser = User::where('username', $requestedUsername)->first();

        if($existingUser) {
            $exists = true;
        } else {
            $exists = false;
        }

        $data = new \stdClass;
        $data->exists = $exists;

        return $this->response($data, '', '');
    }

    public function checkEmail() {
        $requestedEmail = Input::get('email');
        $existingUser = User::where('email', $requestedEmail)->first();

        if($existingUser) {
            $exists = true;
        } else {
            $exists = false;
        }

        $data = new \stdClass;
        $data->exists = $exists;

        return $this->response($data, '', '');
    }

    public function setUsername() {
        if(!Auth::check()) {
            return redirect()->route('index');
        }
        return view('setUsername');
    }

    public function usernameSet() {
        $username = str_replace(' ', '', Input::get('username'));
        $location = Input::get('location');
        $lat = Input::get('lat');
        $lng = Input::get('lng');

        if(Auth::check()) {
            if(!is_null($username) && $username !== '' && !is_null($lat) && !is_null($lng) && $lat !== '' && $lng !== '' && !is_null($location) && $location !== '') {
                $existingUser = User::where('username', $username)->first();

                if($existingUser) {
                    return redirect()->back();
                } else {
                    if(strlen($username) < 2) {
                        return redirect()->back()->with('messageType', 'danger')->with('message', 'Username has to be a minimum of 2 characters!');
                    }
                    $user = Auth::user();
                    $user->username = $username;
                    $user->location = $location;
                    $user->lat = $lat;
                    $user->lng = $lng;
                    $user->save();

                    return redirect()->route('dashboard')->with('messageType', 'success')->with('message', 'Your account has been created. Welcome, ' . $user->username . '!');
                }
            }
        } else {
            return redirect()->route('index');
        }

    }
	
	public function loginTwit($provider = null){
		// echo "Hello";exit;
		// return redirect('dashboard')->with('messageType', 'success')->with('message', Lang::get('messages.logoutMsg'));
		// if(!config("services.$provider")) abort('404');
			try{
				/* 
				$clientId = getenv("POST_TWITTER_ID");
				$clientSecret = getenv("POST_TWITTER_SECRET");
				$redirectUrl = getenv("POST_TWITTER_URL");
				$additionalProviderConfig = ['site' => 'http://placeholder.com'];
				$config = $this->socialite->Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig); */
				Session::put('Twit_verification', true);
				return $this->socialite->with($provider)->redirect();
				
			}catch(Exception $e){
				abort('404');
			}
		/* return redirect()->route('twit.account')->with('messageType', 'info')->with('message', 'Invalid Authentication URL Request') */;
	}
	
	public function loginTwitAuthCallback($provider = null){
		$user = $this->socialite->with($provider)->user();
		echo "<pre>";
		print_r($user);
		die;
	}
}
