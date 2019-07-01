<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Competitions extends MasterModel
{
    //
    use SoftDeletes;
    protected $fillable = ['title','sub_title','expiry_date','price','created_at','last_modified','expiry_date_timestamps'];
    public $timestamps = false;

    public static function add($data) {
        $newCompition = new Competitions();
        foreach($data as $key => $value) {
            $newCompition->$key = $value;
        }

        $newCompition->save();

        return $newCompition;
    }
}
