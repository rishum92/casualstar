<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serviceRequest extends Model
{
    protected $with = [];
     protected $fillable = ['sender_id','receiver_id','user_service_id','service_id','service_name','variable_name','amount','negotiate','created_date','updated_at','status'];

     public function user() {
      return $this->belongsTo('App\Models\User', 'sender_id');
    }
}
