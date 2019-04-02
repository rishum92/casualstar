<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'description', 'img', 'cover', 'dob', 'email', 'password', 'verify_img', 'verify_check', 'text_notes', 'verify_created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function get_user_data($user_id)
    {echo $user_id;exit;
        $users = DB::table('users')
                          ->where('id', $user_id)
                          ->get(); 
        return $users;
    }
}
