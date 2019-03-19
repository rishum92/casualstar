<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\offer_post;
use Redirect;
use Auth;

class offerPostController extends Controller
{
    //insert the post
    public function offer(Request $Request)
    {
      $currency   = $Request->input('currency');
      $rate   = $Request->input('offerrate');
      $detail = $Request->input('offerdetails');
      $user_id    =  Auth::user()->id;
      $user_name    =  Auth::user()->username;
      $user_img    =  Auth::user()->img;

      offer_post::addPost($rate,$detail,$user_id,$user_name,$user_img,$currency);
      return redirect('offers')->with('message', 'Successfully Insert')->with('messageType', 'success');

    }
    
    //fetch the posts
    public function getData()
    {
       $post_data = offer_post::getPost();
       
       return view('offers',['offerpost'=>$post_data]);
    }

    //either intrested or note
    public function intrested(Request $Request)
    { 
        $post_id       = $Request->id;
        $intrested_id  = Auth::user()->id;
        $check_result  = offer_post::checkStatus($post_id,$intrested_id);
        $interested_count = count($check_result);
        

        if(empty($check_result))
        {
          offer_post::intresteUser($post_id,$intrested_id);
          return redirect('offers')->with('message', 'Your interested to this post')->with('messageType', 'success');
        } else
        {
          
         return redirect('offers')->with('message', 'You have already shown interest for this post.')->with('messageType', 'success');
         }
    } 

    //post intrested users
    public function post_intrest_users(Request $Request)
    {
      $post_data = offer_post::getPost();
      $post_id = $Request->id;
      $interested_users = offer_post::post_intrest_users($post_id);
      return view('interested_users',['interested_users'=>$interested_users]);
    }

    //myoffer interested users
     public function myoffer_intrest_users(Request $Request)
    {
      $post_data = offer_post::getPost();
      $post_id       = $Request->id;
      $myoffer_interested_users = offer_post::post_intrest_users($post_id);
      //echo "<pre>";print_r($myoffer_interested_users);die;
      return view('myoffer_interest_users',['myoffer_interested_users'=>$myoffer_interested_users]);
    }

    //logged interested
    public function logged_interested(Request $Request)
    { 
      $post_data = offer_post::getPost();
      $post_id = $Request->id;
      $my_logged_interested_users = offer_post::post_intrest_users($post_id);
      //echo "<pre>";print_r($myoffer_interested_users);die;
      return view('logged_interested',['my_logged_interested_users'=>$my_logged_interested_users]);
    }

    //delete posts
    public function deletePost(Request $Request)
    {
        $post_id = $Request->id;
        offer_post::deleteOffers($post_id);
        return redirect('offers')->with('message', 'Offer delete successfully')->with('messageType', 'success');
    }
    public function deletemyoffer(Request $Request)
    {
      $post_id = $Request->id;
      offer_post::deletemyOffer($post_id);
      return redirect('offers')->with('message', 'My offer delete successfully')->with('messageType', 'success');
    }

    public function send_offer_message(Request $Request)
    {
      $post_data = $Request->all();
      $post_id   =  $Request->post_id;
      $receiver_id   =  $Request->receiver_id;
      $offer_message   =  $Request->offer_message;
      $sender_id = $Request->sender_id;

      $post_data['sender_id']  = Auth::user()->id;
      echo '<pre>';print_r($post_data);exit;
      offer_post::send_offer_message($post_data);
      
    }
}
