<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class competition_user extends Model
{
   public static function insert($user_id,$encrypted_image)
   {
   	    $insertdata = DB::table('competition_interested_users')
   	                ->insert(['user_id'=>$user_id,'user_profile'=>$encrypted_image]);
   	  return $insertdata;
   }
   public static function getdata()
   {
    	$getuserdata = DB::table('competition_interested_users')
    	            ->join('users','id','=','competition_interested_users.user_id')
    	            ->select('users.username','competition_interested_users.*')
                  ->paginate(20);
    	           
      return $getuserdata;	
   }
   public static function existuser($user_id){
    $exist =  DB::table('competition_interested_users')
                  ->join('users','id','=','competition_interested_users.user_id')
                  ->where('competition_interested_users.user_id','=',$user_id)
                  ->get();
    //echo "<pre>";print_r($exist);die;
    return $exist;
   }
   public static function updateexpirydate($date,$user_id)
   {
      $insertdate = DB::table('competition_expiry_date')
                  ->update(['user_id'=>$user_id,'ExpiryDate'=>$date]);
      return $insertdate;
   }
   public static function showdate()
   {
      $showdate = DB::table('competition_expiry_date')
                  ->select('ExpiryDate')
                  ->get();
                 
      return $showdate;  
   }

}