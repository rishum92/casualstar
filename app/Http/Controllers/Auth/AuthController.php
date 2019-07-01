<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Input;
use Auth;
use Hash;
use Image;
use File;
use Session;
use Lang;
use App\Models\UserProvider;
use App\Models\Activity;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AuthController extends Controller
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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout', 'checkUsername','checkEmail']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function register() {
        $rules = array(
            'email'=>'required|email|unique:users',
            'username'=>'required|alpha_num|username|unique:users|min:2|max:16',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required'
        );

        Validator::extend('username', function($field,$value,$parameters){
            return true;
        });

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $data = Input::all();

            $user = new User;
            $user->username = str_replace(' ', '', Input::get('username'));
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->dob = Input::get('dob');
            $user->location = Input::get('location');
            $user->lat = Input::get('lat');
            $user->lng = Input::get('lng');
            $user->social = 0;
            $user->status = 1;
            $user->title = 'USER';
            $user->gender = Input::get('gender');

            $user->save();

            if(array_key_exists('file', $data)) {
                $image = $data['file'];
                $ext = explode('/', $image->getMimeType());
                $x = $data['x'];
                $y = $data['y'];
                $width = $data['width'];
                $height = $data['height'];
                $rotate = $data['rotate'];

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

                if (!file_exists('img/users/' . $user->username)) {
                    mkdir('img/users/' . $user->username, 0777, true);
                }

                if (!file_exists('img/users/' . $user->username . '/previews')) {
                    mkdir('img/users/' . $user->username . '/previews', 0777, true);
                }

                if (!file_exists('img/users/' . $user->username . '/chat')) {
                    mkdir('img/users/' . $user->username . '/chat', 0777, true);
                }

                $uniqId = uniqId();
                $profilePhotoFile = uniqid() . $ext;
                $user->img = $profilePhotoFile;
                $user->save();

                $image->move('img/users/' . $user->username, $profilePhotoFile);

                $profilePhotoChat = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
                $profilePhotoChat->rotate(-$rotate);
                $profilePhotoChat->crop((int) $width, (int) $height, (int) $x, (int) $y);
                $profilePhotoChat->resize(40, 40, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $profilePhotoChat->save('img/users/' . $user->username . '/chat/' . $profilePhotoFile);

                $profilePhotoPreview = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
                $profilePhotoPreview->rotate(-$rotate);
                $profilePhotoPreview->crop((int) $width, (int) $height, (int) $x, (int) $y);
                $profilePhotoPreview->resize(220, 220, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $profilePhotoPreview->save('img/users/' . $user->username . '/previews/' . $profilePhotoFile);



                $profilePhotoImage = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
                $profilePhotoImage->rotate(-$rotate);
                $profilePhotoImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
                $profilePhotoImage->resize(900, 900, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $profilePhotoImage->save();
            }

            Auth::loginUsingId($user->id);
            Session::put('filters', ['distance' => 1000]);

            $loginActivity = new Activity();
            $loginActivity->user_id = Auth::user()->id;
            $loginActivity->activity = 'LOGIN';
            $loginActivity->save();


            return redirect()->route('dashboard')->with('messageType', 'success')->with('message', 'Your account has been created. Welcome, ' . $user->username . '!');
        } else {
            // TODO: Error message for same e-mail needed
            return redirect()->back()->with('messageType', 'danger')->with('message', 'A problem has been encountered while creating your account. Please check all fields and try again.');
        }

    }
	
	public function register_twitter() {
		$rules = array(
            'id_hidden'=>'required',
            'dob'=>'required|date',
            'lat'=>'required',
            'lng'=>'required',
            'gender'=>'required'
        );
		$validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
			return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.loginError'))->with('toggleLoginTwitter', true)->with('user_id',Input::get('id_hidden'));
		}
            // $data = Input::all();
		// $data = Input::all();
		/* print_r($data);
		return; */
		/* print_r($data);
		echo Input::get('dob'); */
/* 
		DB::table('users')
            ->where('id', 3)
            ->update(['title' => "Updated Title"]); */
		$data = Input::all();
		$user = User::find(Input::get('id_hidden'));
		if(!$user){
			return redirect()->route('index')->with('messageType', 'danger')->with('message', 'Not a Valid Registration, Try Again.')->with('toggleLoginTwitter', true)->with('user_id',Input::get('id_hidden'));
		}
		// $user = new User;
		// $user->username = str_replace(' ', '', Input::get('username'));
		// $user->email = Input::get('email');
		// $user->password = Hash::make(Input::get('password'));
		$user->dob = Input::get('dob');
		$user->location = Input::get('location');
		$user->lat = Input::get('lat');
		$user->lng = Input::get('lng');
		$user->social = 1;
		$user->status = 1;
		$user->title = 'USER';
		$user->gender = Input::get('gender');
		// $user->save();
		
		/* $update_action = User::where('id', '=', Input::get('id_hidden'))
            ->update(['dob' => Input::get('dob'), 'location' => Input::get('location'), 'lat' => Input::get('lat'), 'lng' => Input::get('lng'), 'gender' => Input::get('gender'), 'status' => 1 ]);  */
			/* 
		$update_action = User::where('id', '=', Input::get('id_hidden'))
            ->update(['dob' => Input::get('dob'), 'gender' => Input::get('gender'), 'status' => 1 ]); */
		/* if(!$update_action){
			return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.loginError'))->with('toggleLoginTwitter', true);
		} */
		
/* 		if(array_key_exists('file', $data)) {
			$image = $data['file'];
			$ext = explode('/', $image->getMimeType());
			$x = $data['x'];
			$y = $data['y'];
			$width = $data['width'];
			$height = $data['height'];
			$rotate = $data['rotate'];

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

			if (!file_exists('img/users/' . $user->username)) {
				mkdir('img/users/' . $user->username, 0777, true);
			}

			if (!file_exists('img/users/' . $user->username . '/previews')) {
				mkdir('img/users/' . $user->username . '/previews', 0777, true);
			}

			if (!file_exists('img/users/' . $user->username . '/chat')) {
				mkdir('img/users/' . $user->username . '/chat', 0777, true);
			}
			
			$uniqId = uniqId();
			$profilePhotoFile = uniqid() . $ext;
			$user->img = $profilePhotoFile;
			$user->registered = 1;
			$user->save();

			$image->move('img/users/' . $user->username, $profilePhotoFile);

			$profilePhotoChat = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
			$profilePhotoChat->rotate(-$rotate);
			$profilePhotoChat->crop((int) $width, (int) $height, (int) $x, (int) $y);
			$profilePhotoChat->resize(40, 40, function ($constraint) {
				$constraint->aspectRatio();
			});
			$profilePhotoChat->save('img/users/' . $user->username . '/chat/' . $profilePhotoFile);

			$profilePhotoPreview = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
			$profilePhotoPreview->rotate(-$rotate);
			$profilePhotoPreview->crop((int) $width, (int) $height, (int) $x, (int) $y);
			$profilePhotoPreview->resize(220, 220, function ($constraint) {
				$constraint->aspectRatio();
			});
			$profilePhotoPreview->save('img/users/' . $user->username . '/previews/' . $profilePhotoFile);



			$profilePhotoImage = Image::make('img/users/' . $user->username . '/' . $profilePhotoFile);
			$profilePhotoImage->rotate(-$rotate);
			$profilePhotoImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
			$profilePhotoImage->resize(900, 900, function ($constraint) {
				$constraint->aspectRatio();
			});
			$profilePhotoImage->save();
		} */

		Auth::loginUsingId($user->id);
		Session::put('filters', ['distance' => 1000]);

		$user->registered = 1;
		$user->deleted_at = null;
		$user->save();
		
		UserProvider::where('user_id', $user->id)->update(['registered' => 1]);

		$loginActivity = new Activity();
		$loginActivity->user_id = Auth::user()->id;
		$loginActivity->activity = 'LOGIN';
		$loginActivity->save();


		return redirect()->route('dashboard')->with('messageType', 'success')->with('message', 'Your Profile has been Completed. Welcome, ' . $user->username . '!');
    }

    public function login() {
        return view('login', []);
    }

    public function doLogin() {
        $rules = array(
            'email'    => 'required',
            'password' => 'required|min:3'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.loginError'))->with('toggleLogin', true)->with('username', Input::get('email'));
        } else {
            if(strpos(Input::get('email'), '@') > 0) {
                $userdata = array(
                    'email'     => Input::get('email'),
                    'password'  => Input::get('password')
                );
                $user = User::where('email', $userdata['email'])->first();
                
            } else {
                $userdata = array(
                    'username'  => Input::get('email'),
                    'password'  => Input::get('password')
                );
                $user = User::where('username', $userdata['username'])->first();
            }

            if($user) {
                if($user->status == -1) {
                    return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.accountLocked'))->with('toggleLogin', false);
                } elseif($user->status == 0) {
                    $user->status = 1;
                    $user->save();
                }
            }

            if(Auth::attempt($userdata)) {
                $loginActivity = new Activity();
                $loginActivity->user_id = Auth::user()->id;
                $loginActivity->activity = 'LOGIN';
                $loginActivity->save();

                $username = Auth::user()->username;
                return redirect()->route('dashboard')->with('messageType', 'success')->with('message', Lang::get('messages.loginSuccess', ['name' => $username]));
            } else {
                return redirect()->route('index')->with('toggleLogin', true)->with('messageType', 'danger')->with('message', Lang::get('messages.loginError'))->with('username', Input::get('email'));;
            }
        }
    }

    public function logout() {
        $loginActivity = new Activity();
        $loginActivity->user_id = Auth::user()->id;
        $loginActivity->activity = 'LOGOUT';
        $loginActivity->save();
        Auth::logout();
		\Cookie::forget('laravel_session');
		Session::flush();  
        return redirect('/')->with('messageType', 'success')->with('message', Lang::get('messages.logoutMsg'));
    }
	
	
}
