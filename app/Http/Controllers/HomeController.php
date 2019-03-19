<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App;
use Auth;
use Mail;
use Input;
use DB;
use App\offer_post;
use App\Models\Tribute;
use App\competition_user;
class HomeController extends BaseController
{
  public function index() {
  	if(Auth::check()) {
    	return redirect()->route('dashboard');
  	} else {
      $tributeCount = Tribute::count();
    	return view('index', ['tributeCount' => $tributeCount]);
  	}
  }

  public function contact() {
	 return view('contact', []);
  }
   
  public function faq() {
   return view('faq', []);
  }

  public function terms() {
   return view('terms', []);
  }

  public function privacy() {
   return view('privacy', []);
  }

  public function safety() {
   return view('safety', []);
  }

  public function about() {
   return view('about', []);
  }

  public function explore() {
   return view('explore', []);
  }

  public function offers() {
    $user_id = Auth::user()->id;
    $post_data = offer_post::getPost();
    $user_posts = offer_post::get_user_posts();
    $myofferpost = offer_post::myofferPost();
    $myofferpostinterested = offer_post::myofferPostInterested();
    $notification_data = offer_post::offer_notification();

    //echo "<pre>";print_r($notification_data);die;

            DB::table('users')
            ->where('id', $user_id)
            ->update(['notification' => 0]);

    return view('offers', ['offerpost'=>$post_data, 'user_posts'=>$user_posts,'myofferpost'=>$myofferpost,'myofferpostinterested'=>$myofferpostinterested,'my_notifications'=> $notification_data]);

  }

  
  public function bannerAds() {
   return view('bannerAds', []);
  }

  public function supersubs() {
    
          return view('supersubs', []);
  }

  public function sendContact() {
    $name = Input::get('name');
    $emailMessage = Input::get('message');
    $fromEmail = Input::get('email');
    $telephone = Input::get('telephone');

    if($name == "" || $emailMessage == "" || $fromEmail == "") {
      return redirect()->back()->with('message', 'You need to fill out all the required fields.')->with('messageType', 'danger');
    }

    // $toEmail = 'casualstar.uk.info@gmail.com';
    $toEmail = 'casualstar.uk.info@gmail.com';

    Mail::send('emails.contact', ['emailMessage' => $emailMessage], function($email) use($name, $fromEmail, $toEmail) {
        $email->from($fromEmail, $name)->to($toEmail)->subject('CasualStar: New message');
    });

    return redirect()->back()->with('message', 'Thanks for your message!')->with('messageType', 'success');

  }
  
  public function competitions() {
    // $user_id = Auth::user()->id;
    // $getdata = competition_user::getdata();
    // $exist = competition_user::existuser($user_id);
    // return view('competitions',['competitionuser' =>$getdata,'exists'=>$exist]);
      if(Auth::check()) {
        $user_id = Auth::user()->id;
        $getdata = competition_user::getdata();
        $exist = competition_user::existuser($user_id);
        $showdate= competition_user::showdate();
        $updatedate = $showdate[0]->ExpiryDate;
        $date_array = explode("-",$updatedate); // split the array
        $var_year = $date_array[0]; //day seqment
        $var_month = $date_array[1]; //month segment
        $var_day = $date_array[2]; //year segment
        $new_date_format = "$var_day/$var_month/$var_year";
        
        return view('competitions',['competitionuser' =>$getdata,'exists'=>$exist,'showdate'=>$new_date_format]);
    } else {
        $getdata = competition_user::getdata();
        $showdate= competition_user::showdate();
        $updatedate = $showdate[0]->ExpiryDate;
        $date_array = explode("-",$updatedate); // split the array
        $var_year = $date_array[0]; //day seqment
        $var_month = $date_array[1]; //month segment
        $var_day = $date_array[2]; //year segment
        $new_date_format = "$var_day/$var_month/$var_year";
        return view('competitions',['competitionuser' =>$getdata,'showdate'=>$new_date_format]);
    }
  }


}
