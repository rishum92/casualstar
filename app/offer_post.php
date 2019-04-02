<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;
use Mail;

class offer_post extends Model
{
 use SoftDeletes;
 public $timestamps = false;

 public static function get_user_data($user_id)
  {
    $user = DB::table('users')
            ->where('id', '=', $user_id)
            ->first();
           
    return $user;
  }

  // public static function get_interest_notification($user_id)
  // {
  //     $interest_notification = DB::table('offer_interested_users')
  //                             ->select('status')
  //                             ->where('id', '=', $user_id)
  //                             ->get();
  //     return $interest_notification ;                      
           
  // }
  
   //insert the post modal
   public static function addPost($rate, $detail, $user_id, $user_name, $user_img, $currency)
   {
      $rate = str_replace(",", "", $rate);
      $insert = DB::table('offer_post')
            -> insert(['offer_rate'=>$rate,'currency'=>$currency,'offer_details'=>$detail,'user_id'=>$user_id]);


    $get_notification_value = DB::table('users')
                          ->select('notification')
                          ->where('id', $user_id)
                          ->get();
    $notification_update = DB::table('users')
                          ->increment('notification');



   }

   //get notification alert
   public static function offer_notification()
   {
      $user_id = Auth::user()->id;
      $get_notification_data = DB::table('users')
                          ->select('notification')
                          ->where('id',$user_id)
                          ->get();

      return $get_notification_data;
   }


   //fetch the post modal
   public static function getPost()
   {  
      $post_data = DB::table('offer_post')
                  ->join('users', 'offer_post.user_id', '=', 'users.id')
                  ->select('offer_post.id as post_id','offer_post.created_at as offer_post_date','offer_post.*','users.*')
                  ->orderBy('offer_post.created_at', 'DESC')
                  ->paginate(10);


      foreach ($post_data as $key => $post) {
        $interest_count = DB::table('offer_interested_users')
                          ->select('id')
                          ->where('post_id', $post->post_id)
                          ->get(); 

        $post_data[$key]->intrest_count = count($interest_count);
      }

      //echo  "<pre>"; print_r($post_data) ; die; 
      return $post_data;         
   }

   //fetch the post modal
   public static function get_user_posts()
   {
      $user_id = Auth::user()->id;

      if (Auth::user()->gender == 'male') 
      {
        $my_posts = DB::table('offer_post') 
                      ->select('id')
                      ->where('user_id', $user_id )  
                      ->get(); 
        if(!empty($my_posts)){
          foreach ($my_posts as $post) {
            $user_posts[] = $post->id;
          }
        } else {
          return $my_posts;
        }
        
      }
      else
      {
        $check_exist = DB::table('offer_interested_users') 
                      ->where('user_id', $user_id )  
                      ->get();
        // if(empty($check_exist))
        // {
        //    echo "note exist";die;
        // }
        // else
        // {
        //   echo "exist";die;
        // }

        $my_interests = DB::table('offer_interested_users') 
                      ->select('post_id')
                      ->where('user_id', $user_id )  
                      ->get(); 
        if(!empty($my_interests)){
          foreach ($my_interests as $interest) {
            $user_posts[] = $interest->post_id;
          }
        } else {
          return $my_interests;
        }

      }

     
      //echo  "<pre>"; print_r($user_posts) ; die; 
      return $user_posts;         
   }

  //my offer post
   public static function myofferPost()
   {
      $myofferpost = DB::table('offer_post')
                    ->join('offer_interested_users', 'offer_post.id', '=', 'offer_interested_users.post_id')
                    ->select('offer_post.*')
                    ->where('offer_post.user_id','=',Auth::user()->id)
                    ->groupBy('offer_post.id')
                    ->orderBy('offer_post.created_at','DESC')
                    ->paginate(10);
      //echo "<pre>";print_r($myofferpost);die;

      foreach ($myofferpost as $key => $post) {
        $interest_count = DB::table('offer_interested_users')
                          ->select('id')
                          ->where('post_id', $post->id)
                          ->get(); 
        $myofferpost[$key]->intrest_count = count($interest_count);
      }
              
      return $myofferpost;              
   }

   public static function myofferPostInterested()
   {
      $myofferpostinterested = DB::table('offer_post')
                    ->join('users', 'offer_post.user_id', '=', 'users.id')
                    ->join('offer_interested_users', 'offer_post.id', '=', 'offer_interested_users.post_id')
                    ->select('offer_post.*','users.username','users.img')
                    ->where('offer_interested_users.user_id','=',Auth::user()->id)
                    ->where('offer_interested_users.status','=',0)
                    ->groupBy('offer_post.id')
                    ->orderBy('offer_post.created_at', 'desc')
                    ->paginate(10);
      //echo "<pre>";print_r($myofferpostinterested);die;

      foreach ($myofferpostinterested as $key => $post) {
        $interest_count = DB::table('offer_interested_users')
                          ->select('id')
                          ->where('post_id', $post->id)
                          ->get(); 
        $myofferpostinterested[$key]->intrest_count = count($interest_count);
      }
      //echo "<pre>";print_r($myofferpostinterested);die;
      return $myofferpostinterested;              
   }


   //
   public static function intrestedCount()
   {
     $intrested = DB::table('offer_post')
                ->join('offer_interested_users', 'offer_post.id', '=', 'offer_interested_users.post_id')
                ->where('offer_interested_users.post_id',3)
                ->get();
      
   
      return $intrested;           
   }

   public static function checkStatus($post_id,$intrested_id)
   {
      $users = DB::table('offer_interested_users')
                    ->select('post_id','user_id')
                    ->where('post_id',$post_id)
                    ->where('user_id',$intrested_id)
                    ->get(); 
      //echo "<pre>";print_r($users);die;        
      return $users;
    }

    public static function post_intrest_users($post_id)
    {
      $users = DB::table('offer_interested_users')
                    ->join('users', 'offer_interested_users.user_id', '=', 'users.id')
                    ->where('offer_interested_users.post_id', '=', $post_id)
                    ->select('users.*', 'offer_interested_users.*')
                    ->orderBy('offer_interested_users.created_at')
                    ->get();
            return $users;
    }

    public static function interest_user($post_id, $intrested_id, $user_id)
    {
      DB::table('offer_interested_users')
      ->insert(['post_id'=>$post_id,'user_id'=>$intrested_id]);

      $count_users = DB::table('offer_interested_users')
                      ->select('user_id') 
                      ->where('post_id',$post_id)
                      ->get(); 

      $point_users = count($count_users) ; 
      if($point_users < 10)
      {
        DB::table('offer_post')
        ->where('id',$post_id)
        ->update(['p_g_p'=>'10']);
      }
      else
      {
        DB::table('offer_post')
        ->where('id',$post_id)
        ->update(['p_g_p'=>'50']);
      }

      $count_points = self::count_points($user_id);

      if($count_points >= 1000)
      {
        DB::table('users')
        ->where('id',$user_id)
        ->update(['pgp_count'=>$count_points]);

        DB::table('offer_post')
        ->where('user_id',$user_id)
        ->update(['p_g_p'=>'0']);
      }

      return $count_points;
      
      //echo "<pre>";print_r($point_users);die;               
    } 

    //count point of post

    public static function count_points($user_id)
    { 
        $count_points = DB::table('offer_post')
                      ->where('user_id','=',$user_id)
                      ->select('p_g_p')
                      ->sum('p_g_p');

        $user_points = DB::table('users')
                      ->where('id','=',$user_id)
                      ->select('pgp_count')
                      ->sum('pgp_count');
               
        return $count_points+$user_points;
    }

   //delete offers 
   public static function deleteOffers($post_id)
   {
       
       $deleteoffer = DB::table('offer_post')
                     ->where('id',$post_id)
                     ->delete();

   }
  
  //delete my offers
  public static function deletemyOffer($post_id)
  {
      $deleteoffer = DB::table('offer_post')
                     ->where('id', $post_id)
                     ->delete();
  } 

  //delete logged interest
  public static function delete_logged_interest($post_id)
  {
      $deleteoffer = DB::table('offer_interested_users')
                     ->where('post_id', $post_id)
                     ->update(['status'=>1]);
  }

   public static function interestedPostBorder($userid_post_border)
   {
      $interestedPost = DB::table('offer_post')
                        ->get();
        foreach ($interestedPost as $key => $post) {
        $interest_count = DB::table('offer_interested_users')
                          ->select('user_id')
                          ->where('user_id', $userid_post_border)
                          ->get(); 
        }
       //echo "<pre>"; print_r($interest_count); die;
        return $interest_count;
   }

  public static function send_offer_message($post_data)
  {

      $message_send = DB::table('offer_message')
                     -> insert(['post_id'=>$post_data['post_id'], 'sender_id'=>$post_data['sender_id'], 'receiver_id'=>$post_data['receiver_id'], 'offer_message'=>$post_data['offer_message']]);
      return $message_send;
  }


  public static function pgp_activation()
  {
    DB::table('users')
    ->where('id',Auth::user()->id)
    ->update(['pgp_status'=>1]);

    DB::table('users')
    ->where('id', Auth::user()->id)
    ->update(['pgp_count' => DB::raw('pgp_count-1000')]);
  }











}
