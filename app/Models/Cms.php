<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cms extends MasterModel
{
    //
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['title','description','created_at','updated at' ];
}

