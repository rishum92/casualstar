<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Illuminate\Support\Str;
use Lang;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    protected $redirectTo = '/';

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        if($user) {
            if($user->status == -1) {
                return redirect()->route('index')->with('messageType', 'danger')->with('message', Lang::get('messages.accountLocked'))->with('toggleLogin', false);
            } elseif($user->status == 0) {
                $user->status = 1;
                $user->save();
            }
        }

        Auth::guard($this->getGuard())->login($user);
    }
}
