<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CompetitionUsers extends MasterModel
{
    use SoftDeletes;
    protected $fillable = ['compition_id','user_id','created_at'];
    public $timestamps = false;
    protected $table = 'competition_users';

}
