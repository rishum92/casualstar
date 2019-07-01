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
use DateTime;
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
    
    DB::table('users')->where('id', $user_id)->update(['notification' => 0]);

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

    if($name == "" || $emailMessage == "" || $fromEmail == "") 
    {
        return redirect()->back()->with('message', 'You need to fill out all the required fields.')->with('messageType', 'danger');
    }

    $toEmail = 'casualstar.uk.info@gmail.com';

    Mail::send('emails.contact', ['emailMessage' => $emailMessage], function($email) use($name, $fromEmail, $toEmail) {
        $email->from($fromEmail, $name)->to($toEmail)->subject('CasualStar: New message');
    });

    return redirect()->back()->with('message', 'Thanks for your message!')->with('messageType', 'success');

  }
  
  public function competitions() {
    if(Auth::check()) {
      $user_id = Auth::user()->id;
      $get_data = competition_user::get_data();
      $user_exist = competition_user::is_user_exist($user_id);
      $voter_count = competition_user::vote_count($user_id);
      $total_voters_count = count($voter_count);
      $exist_voters = competition_user::exist_voters($user_id);
      
      $show_date= competition_user::show_date();
      $updatedate = $show_date[0]->ExpiryDate;
      $date_array = explode("-",$updatedate); // split the array
      $var_year = $date_array[0]; //day seqment
      $var_month = $date_array[1]; //month segment
      $var_day = $date_array[2]; //year segment
      $new_date_format = "$var_day/$var_month/$var_year";
      
      $show_terms_condition= competition_user::show_terms_condition();
      $get_title= competition_user::get_title();
      
      return view('competitions',['competitionuser' =>$get_data,'exists'=>$user_exist,'showdate'=>$new_date_format,'expire_date'=>$updatedate,'termscondition'=>$show_terms_condition,'voter_count'=>$voter_count,'get_title'=>$get_title,'total_voters_count'=>$total_voters_count, 'exist_voters'=>$exist_voters]);
    } else {
      $get_data = competition_user::get_data();
      $show_date= competition_user::show_date();
      $get_title= competition_user::get_title();
      $updatedate = $show_date[0]->ExpiryDate;
      $date_array = explode("-",$updatedate); // split the array
      $var_year = $date_array[0]; //day seqment
      $var_month = $date_array[1]; //month segment
      $var_day = $date_array[2]; //year segment
      $new_date_format = "$var_day/$var_month/$var_year";
      
      return view('competitions',['competitionuser' =>$get_data,'showdate'=>$new_date_format,'get_title'=>$get_title]);
    }
  }

  public function competition_vote_amount_edit(Request $request)
  {   
    $vote_amount = $request->firstplace_amount;
    echo $vote_amount;die;
    $hidden_user_id_for_voteamount = $request->hidden_user_id;
    competition_user::update_amount_edit($vote_amount,$hidden_user_id_for_voteamount);
    $select_vote_amount     = competition_user::select_vote_amount($hidden_user_id_for_voteamount);
    $data = array('competitionuservoteamount' => $select_vote_amount);
    
    return json_encode($data);

  }

  public function competition_vote_second_place_amount_edit(Request $request)
  {   
    $vote_amount = $request->secondplace_amount;
    $hidden_user_id_for_voteamount = $request->hidden_user_id;
    competition_user::update_second_place_amount_edit($vote_amount,$hidden_user_id_for_voteamount);
    $select_vote_amount     = competition_user::select_vote_amount($hidden_user_id_for_voteamount);
    $data = array('competitionuservoteamount' => $select_vote_amount);
    
    return json_encode($data);

  }
  
  public function competition_vote_third_place_amount_edit(Request $request)
  {   
    $vote_amount = $request->thirdplace_amount;
    $hidden_user_id_for_voteamount = $request->hidden_user_id;
    competition_user::update_third_place_amount_edit($vote_amount,$hidden_user_id_for_voteamount);
    $select_vote_amount     = competition_user::select_vote_amount($hidden_user_id_for_voteamount);
    $data = array('competitionuservoteamount' => $select_vote_amount);
  
    return json_encode($data);
  
  }

}