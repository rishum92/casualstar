<?php

namespace App\Models;

use App;
use Carbon\Carbon;
use Schema;
use Image;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
	 protected $fillable = ['service_name','user_id','added_time'];
}
