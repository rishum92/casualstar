<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userService extends Model
{
    //
    protected $fillable = ['user_id','service_id','variable_name','amount','negotiate','status'];
}
