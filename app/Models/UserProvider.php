<?php

namespace App\Models;

use App;
use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\UserProvider;

class UserProvider extends MasterModel {
    use SoftDeletes;

}