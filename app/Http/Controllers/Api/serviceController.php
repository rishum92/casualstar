<?php

namespace App\Http\Controllers\Api;
use Mail;
use App\Http\Controllers\Controller as MasterController;
use App;
use Carbon\Carbon;
use Input;
use Request;
use Image;
use Auth;
use Lang;
use Hash;
use Session;
use App\Models\User;
use App\Models\UserProvider;
use App\Models\Favorite;
use App\Models\Photo;
use App\Models\UserInterest;
use App\Models\Wink;
use App\Models\Online;
use App\Models\DonationAttempt;
use App\Models\Chat;
use App\Models\currency;
use App\Models\service;
use App\Models\Tribute;
use App\Models\userService;
use App\Models\serviceVariable;
use App\Models\serviceRequest;
use App\Models\Notification;
use Geotools;
use DB;
use Twitter;
use File;
use Validator;

class serviceController extends MasterController
{
    public function getAllCurrency(){
        
        $currency = currency::all();
        return $this->response($currency , '' , '');
        
        
    }
    
    
   public function sendNotification(){
  $favorites = Favorite::where('liked_user_id', Auth::user()->id)->get();
  
  foreach($favorites as $key => $favuser) {
    $notification = new Notification;
    $notification->from_id = Auth::user()->id;
    $notification->to_id   = $favorites[$key]->user_id;
    $notification->message = ' New Private Gallery Upload.'; 
    $notification->type    = 'PRIVATE_GALLERY'; 
    $notification->is_read = 'FALSE'; 
    $notification->save();   
  }
         
   $allUsers =  DB::table('service_requests')
           ->selectRaw('service_requests.*,users.email,users.first_name,users.last_name,users.username')
           ->where('service_requests.receiver_id',Auth::user()->id) 
            ->where('service_requests.service_id',10) 
           ->leftJoin('users','users.id','=','service_requests.sender_id')
           ->where('service_requests.status','COMPLETED')
           ->get();
   
   $name = 'CasualStar';
   $fromEmail = 'casualstar.uk.info@gmail.com';
   foreach($allUsers as $user){
     
     /* New Private Gallery Upload Notification to Male */
       //$toEmail ="amit.p@aqbsolutions.com";
     $toEmail = $user->email;
     /* $usr=Auth::user();
       $last_name = (is_null($usr->last_name)) ? '' : $usr->last_name;
       $users_name = (is_null($usr->first_name) || $usr->first_name=='') ? $usr->username : $usr->first_name . ' ' . $last_name; */
       $usr=$user;
       $last_name = (is_null($usr->last_name)) ? '' : $usr->last_name;
       $users_name = (is_null($usr->first_name) || $usr->first_name=='') ? $usr->username : $usr->first_name . ' ' . $last_name;
     
       try{
       /* $notification = new Notification;
       $notification->from_id = Auth::user()->id;
       $notification->to_id   = $user->sender_id;
       $notification->message = ' New Private Gallery Upload success.'; 
       $notification->type    = 'PRIVATE_GALLERY'; 
       $notification->is_read = 'FALSE'; 
       $notification->save(); */
        
       /*$sendEmail = Mail::send('emails.notification', ['emailMessage' => $users_name.' uploaded new picture(s) in private gallery'], function($email) use($name, $fromEmail, $toEmail) {
           $email->from($fromEmail, $name)->to($toEmail)->subject('CasualStar: Private Gallery Uploaded');
       });*/

        $mailin = new Mailin('amit.p@aqbsolutions.com', '3T6XbqRwdYcapJ2z');
        $mailin->
        addTo($toEmail , 'CASUAL STAR')->
        setFrom($fromEmail , 'CASUAL STAR')->
        setReplyTo($fromEmail , 'CASUAL STAR')->
        setSubject('CasualStar: New Private Gallery Upload')->
        setHtml('<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body><h3>Hey '.$users_name.'</h3><p>'.Auth::user()->username.' has uploaded a new Private Gallery image. Log in now to see her new exclusive content while you still have access to her Private Gallery.</p><br/><p><strong>Please do not reply to this email.</strong></p><br/><p><strong>Casualstar.uk</strong></p></body></html>');
        $res = $mailin->send();

       }catch(Exception $e){
           continue;
       }
   }
  
 }

  public function testmail(){
   
$mailin = new Mailin('amit.p@aqbsolutions.com', '3T6XbqRwdYcapJ2z');
$mailin->
addTo('amit.p@aqbsolutions.com', 'amit patra')->
setFrom('amit.p@aqbsolutions.com', 'amit patra')->
setReplyTo('amit.p@aqbsolutions.com','amit patra')->
setSubject('Enter the subject here')->
setHtml('<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body><h3>CasualStar: New message received</h3>    <p>{{ $emailMessage }}</p></body></html>');
$res = $mailin->send();


    }
  public function getNotifications(){
    $notifications = Notification::where('notifications.to_id', Auth::user()->id)
             ->orderBy('created_at' , 'DESC')
             ->whereNull('deleted_at')
             ->get();

    foreach($notifications as $notification) {
      $user = User::find($notification->from_id);
      $notification->username = $user->username;
      $notification->created_at_human = $notification->created_at->format('d M Y, g:i:s A');
    }

    Notification::where('to_id',Auth::user()->id)->update(['is_read'=>'TRUE']);    
    return $this->response($notifications, 'E-mail sent.', 'E-mail not sent.');
             
 }

 public function deleteNotification($id){
     if($id=='all'){
     Notification::where('to_id',Auth::user()->id)->delete();
     }else{
     Notification::destroy($id);
     }

      $mes=Lang::get('messages.deleteSuccess');
       
      return $this->response('success',$mes , ''); 
 }

    
    public function getAllService(){
       $service = DB::table('services as s')
               ->selectRaw('s.*,us.variable_name,us.amount,us.negotiate,us.id as usId')
               ->leftJoin('user_services as us',function($join){
                   $join->on('us.service_id','=','s.id');
                   $join->where('us.user_id','=',Auth::user()->id)
                          ->where('us.status','=',1);
               })
         ->where('s.user_id','=',1)
         ->orwhere('s.user_id','=',Auth::user()->id)
               ->orderBy('s.user_id','ASC')
               ->orderBy('s.service_name','ASC')
               ->get();
        
        foreach($service as $key=>$val){
          $id=$val->id;
          $serviceVariable = serviceVariable::where("service_id",$id)->get();
          $val->variable_list=$serviceVariable;
        }
       return $this->response($service , '' , '');
   }


   public function getAllServiceVariable(){
        
        $serviceVariable = serviceVariable::all();
        return $this->response($serviceVariable , '' , '');
        
    }
   public function deleteUserService($id){
      
        $service= userService::find($id);
        $service->variable_name = "";
        $service->amount        = "0";
        $service->negotiate = "false";
        $service->status       = 0;
        $service->save();   serviceRequest::where('user_service_id',$id)->delete();
          $res = new \stdClass();
      return $this->response($res , Lang::get('messages.seaviceDelete'), '');
   }
    
    
    public function getAllUserServices($username){
       $user = User::where('username', $username)->first();
       if(!$user){
         return $this->response(false, '' , 'Invalid username');  
       }
  
     // DB::enableQueryLog();
   $rest[] = Array();
   $rest['query'] = null;
   $rest['bindings'] = null;
  $service = DB::table('user_services as us')
     ->selectRaw('us.*,s.service_name, s.user_id as SID, (select status from service_requests where sender_id='.Auth::user()->id.' and receiver_id=us.user_id and user_service_id=us.id order by id desc limit 0,1) as sr_status, (select variable_name from service_requests where sender_id='.Auth::user()->id.' and receiver_id=us.user_id and user_service_id=us.id order by id desc limit 0,1) as SRVNAME')
     ->leftJoin('services as s','s.id','=','us.service_id')
     ->where('us.user_id',$user->id)
     ->where('us.status','=',1)
     ->get();
     // $rest = DB::getQueryLog();
    $userService=userService::where('user_id',$user->id)->where('service_id',10)->where('status','=',1)->first();
      $iwantaccess=0;
      if($userService&&$userService->id){
        $iwantaccess=$userService->id;
      }
       return $this->response(array("service"=>$service,"currency_code"=> $user->currency_code,"iwantaccess"=>$iwantaccess, 'qry'=>$rest), '' ,'');  
   }

   public function sendServiceRequest(Request $request) {
       $user = User::where('username', Input::get('username'))->first();
       if(!$user){
         return $this->response(false, '' , 'Invalid username');  
       }

       $tribute = new Tribute();
       $tribute->type = 'SERVICE';
       $tribute->user_id = Auth::user()->id;
       $tribute->to_user_id = $user->id;
       $tribute->save();

       $user = User::where('username', Input::get('username'))->first();
       $user_service = DB::table('user_services as us')
                       ->selectRaw('us.*,s.service_name,(select currency_code from users where id=us.user_id)as currency_code')
                       ->leftJoin('services as s','s.id','=','us.service_id')
                       ->where('us.id',Input::get('service_id'))
                       ->first();
  /* $chk_service = serviceRequest::where('user_service_id',$user_service->service_id)->delete();
  if(!empty($chk_service)){   return $this->response(false, '' , 'Request already Deleted');  } */  if(count($user_service) > 0){   if($user_service->negotiate == "false" && ($user_service->variable_name == '' || !empty($user_service->variable_name)) && $user_service->status == 0){      return $this->response(false, '' , 'Request already Deleted');    }  }else{   return $this->response(false, '' , 'Request already Deleted');   }
     $amount=0;
     if(!empty($user_service->amount)){
      $amount=$user_service->amount;
     }
       $service = new serviceRequest;
       $service->sender_id =   Auth::user()->id;
       $service->receiver_id = $user->id;
       $service->user_service_id = Input::get('service_id'); 
       $service->service_id = $user_service->service_id; 
       $service->service_name = $user_service->service_name;
       $service->variable_name = $user_service->variable_name;
       $service->amount = $amount;
       $service->negotiate = $user_service->negotiate;
       $service->status = 'PENDING'; 
       $service->save();

       
   $name = 'CasualStar';
   $fromEmail = 'casualstar.uk.info@gmail.com';
  
  /* (New Private Gallery Request) && (New Content Request) Mail To Female */
       //$toEmail ="amit.p@aqbsolutions.com";
        $toEmail = $user->email;
       $last_name = (is_null($user->last_name)) ? '' : $user->last_name;
       $users_name = (is_null($user->first_name) || $user->first_name=='') ? $user->username : $user->first_name . ' ' . $last_name;
       
       try{
    $subject = "";
        if($user_service->service_id == 10){
      $mess= Auth::user()->username." has sent a new subscription request to your Private Gallery.  Login to your profile now to gain your tribute/ content fee and complete the request.";
      $sub = "New Private Gallery Request";
      try
      {   
        if($user->social == 1 && $user->twit_private_enable == 1){
          $twit_user = UserProvider::where('user_id',$user->id)->first();
          if($twit_user){
            $twit_user_date = $twit_user->twit_pg_date;
            if($twit_user_date == null){
              $twit_user->twit_pg_date = date("Y-m-d");
              $twit_user->twit_pg_count = 1;
              $twit_user->save();
              $twit_user_date = date("Y-m-d");
            }else if(strtotime($twit_user_date) < strtotime(date("Y-m-d"))){
              $twit_user->twit_pg_date = date("Y-m-d");
              $twit_user->twit_pg_count = 0;
              $twit_user->save();
              $twit_user_date = date("Y-m-d");
            }
            
            if((strtotime($twit_user_date) == strtotime(date("Y-m-d"))) && ($twit_user->twit_pg_count <= $user->twit_private_limit || $user->twit_private_limit == -1) && $twit_user->provider == 'twitter'){
              try
              {
                $twit_text = "I have just received a new subscription to my Private Gallery at www.casualstar.uk/users/".urlencode($user->username)."  #Findom #ExclusiveContent.";
                // $twit_text = "Message Received.";
                Twitter::reconfigure([
                  'consumer_key'               => getenv('TWITTER_ID'),
                  'consumer_secret'            => getenv('TWITTER_SECRET'),
                  'token'                      => $twit_user->access_token,
                  'secret'                     => $twit_user->access_token_secret,
                ]);
                $newTwitte = ['status' => $twit_text];

                $uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path() . '/img/twit/autoTweetSubsription_1.jpg')]);
                if(!empty($uploaded_media)){
                  $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
                // Sabbir Token & Secret Token Used
                
                $tot_count = $twit_user->twit_pg_count + 1;
                $twitter = Twitter::postTweet($newTwitte);
                $twit_user->twit_pg_count = $tot_count;
                $twit_user->save();
              }catch(\Exception $e_all){
                $service['log_err'] = 'Error';
              }
            }
          }
        }
        else if($user->social == 0 && $user->twit_private_enable == 1){
          $twit_user = DB::table('user_twit_details')->where('user_id',$user->id)->first();
          if($twit_user){
            $twit_user_date = $twit_user->twit_pg_date;
            if($twit_user_date == null){
              $update_twit = DB::table('user_twit_details')->update(['twit_pg_date' => date("Y-m-d"), 'twit_pg_count' => 0])->where('id',$twit_user->id);
            
              /* $twit_user->twit_pg_date = date("Y-m-d");
              $twit_user->twit_pg_count = 1;
              $twit_user->save(); */
              $twit_user_date = date("Y-m-d");
            }else if(strtotime($twit_user_date) < strtotime(date("Y-m-d"))){
              $update_twit = DB::table('user_twit_details')->update(['twit_pg_date' => date("Y-m-d"), 'twit_pg_count' => 0])->where('id',$twit_user->id);
              /* $twit_user->twit_pg_date = date("Y-m-d");
              $twit_user->twit_pg_count = 0;
              $twit_user->save(); */
              $twit_user_date = date("Y-m-d");
            }

            if((strtotime($twit_user_date) == strtotime(date("Y-m-d"))) && ($twit_user->twit_pg_count <= $user->twit_private_limit || $user->twit_private_limit == -1) && $twit_user->provider == 'twitter'){
              
                $twit_text = "I have just received a new subscription to my Private Gallery at www.casualstar.uk/users/".urlencode($user->username)."  #Findom #ExclusiveContent.";
                // $twit_text = "Message Received.";
                Twitter::reconfigure([
                  'consumer_key'               => getenv('TWITTER_ID'),
                  'consumer_secret'            => getenv('TWITTER_SECRET'),
                  'token'                      => $twit_user->access_token,
                  'secret'                     => $twit_user->access_token_secret,
                ]);
                $newTwitte = ['status' => $twit_text];

                $uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path() . '/img/twit/autoTweetSubsription_1.jpg')]);
                if(!empty($uploaded_media)){
                  $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
                // Token & Secret Token Used
                
                // $newTwitte['format'] = 'array';
                
                $tot_count = $twit_user->twit_pg_count + 1;
                $twitter = Twitter::postTweet($newTwitte);
                
                $update_twit = DB::table('user_twit_details')->update(['twit_pg_count' => $tot_count])->where('id',$twit_user->id);
                /* $twit_user->twit_pg_count = $tot_count;
                $twit_user->save(); */
            }
          }
        }
      }catch(\Exception $em){
      }
        }else{
      $mess= Auth::user()->username." has sent a new request.  Login to your profile now to gain your tribute/ content fee and complete the request.";
      $sub = "New Content Request";
    }
       /*$sendEmail = Mail::send('emails.notification', ['emailMessage' => $mess], function($email) use($name, $fromEmail, $toEmail) {
           $email->from($fromEmail, $name)->to($toEmail)->subject('CasualStar: Request for Private Gallery Subscription');
       });*/

       $mailin = new Mailin('amit.p@aqbsolutions.com', '3T6XbqRwdYcapJ2z');
        $mailin->
        addTo($toEmail , 'CASUAL STAR')->
        setFrom($fromEmail , 'CASUAL STAR')->
        setReplyTo($fromEmail , 'CASUAL STAR')->
        setSubject('CasualStar: '.$sub.'')->
        setHtml('<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body><h3>Hey '.$users_name.',</h3><p>'.$mess.'</p><br/><p><strong>Please do not reply to this email.</strong></p><br/><p><strong>Casualstar.uk</strong></p></body></html>');
        $res = $mailin->send();

       }catch(Exception $e){
           // continue;
       }
       $res = new \stdClass();
       return $this->response($service, Lang::get('messages.seaviceRequestSave'), '');
   }
   public function updateUserCurrency($currency_code){
        $user = Auth::user();
        if($currency_code=="0"){
        $currency_code="";
        }
        $user->currency_code = $currency_code;
        $user->save();
        return $this->response("success" , Lang::get('messages.currencySet') , '');
    }

   public function services() {
    $user = Auth::user();
  $this->privateGalleryAccess($user->username);
    
    return view('services', ['user' => $user, 'username' => $user->username]);
    }
    public function saveService() {
        $service= userService::firstOrNew(array(
                                    'user_id'=> Auth::user()->id ,
                                    'service_id' => Input::get('service_id')
                                ));
        $service->service_id    = Input::get('service_id');
        $service->variable_name = Input::get('variable_name');
        $service->amount        = Input::get('amount');
        $service->negotiate = Input::get('negotiate');
        $service->user_id       = Auth::user()->id;
        $service->status       = 1;
        $service->save();
        serviceRequest::where('status','=','PENDING')->where('service_id','=',$service->service_id)->where('receiver_id','=',$service->user_id)->delete();
        $res = new \stdClass();
        return $this->response($service, Lang::get('messages.seaviceSave'), '');
    }
   public function changeServiceRequestStatus($id,$status){

  if($status==1){
           $serviceRequest= serviceRequest::find($id);

           $serviceRequest->confirm_date=date('Y-m-d H:i:s');
           $serviceRequest->status="COMPLETED";
           $serviceRequest->save();

           $tribute = new Tribute();
           $tribute->type = 'SERVICE';
           $tribute->user_id = $serviceRequest->sender_id;
           $tribute->to_user_id = Auth::user()->id;
           $tribute->save();

           if($serviceRequest->service_id==10){
               $notification = new Notification;
               $notification->from_id = Auth::user()->id;
               $notification->to_id   = $serviceRequest->sender_id;
               $notification->message = $serviceRequest->variable_name;
               $notification->type    = 'PRIVATE_GALLERY_MALE'; 
               $notification->is_read = 'FALSE'; 
               $notification->save();
               $notification = new Notification;
               $notification->from_id = $serviceRequest->sender_id;
               $notification->to_id   = Auth::user()->id;
               $notification->message = $serviceRequest->variable_name;
               $notification->type    = 'PRIVATE_GALLERY_FEMALE'; 
               $notification->is_read = 'FALSE'; 
               $notification->save();
   $user = User::where('id', $serviceRequest->sender_id)->first();
   $name = 'CasualStar';
   $fromEmail = 'casualstar.uk.info@gmail.com';
  $user_date = "No";
    /* Access Granted to Male */
       //$toEmail ="amit.p@aqbsolutions.com";
        $toEmail = $user->email;
       $last_name = (is_null($user->last_name)) ? '' : $user->last_name;
       $users_name = (is_null($user->first_name) || $user->first_name=='') ? $user->username : $user->first_name . ' ' . $last_name;
       $found_user = User::where('id', Auth::user()->id)->first();
       try{
        $mess="You have been granted subscription access to ".Auth::user()->username."/’s Private Gallery. Log in now to see her new exclusive content while you still have access to her Private Gallery.";
        
       /*$sendEmail = Mail::send('emails.notification', ['emailMessage' => $mess], function($email) use($name, $fromEmail, $toEmail) {
           $email->from($fromEmail, $name)->to($toEmail)->subject('CasualStar: Private Gallery Access Granted');
       });*/
     // $send_user = User::where('id', $serviceRequest->sender_id)->first(); 
     if($found_user->social == 1 && $found_user->twit_enable == 1){
      $twit_user = UserProvider::where('user_id',$found_user->id)->first();
      if($twit_user){
        $twit_user_date = $twit_user->twit_date;
        if($twit_user_date == null){
          $twit_user->twit_date = date("Y-m-d");
          $twit_user->twit_count = 0;
          $twit_user->save();
          $twit_user_date = date("Y-m-d");
        }else if(strtotime($twit_user_date) < strtotime(date("Y-m-d"))){
          $twit_user->twit_date = date("Y-m-d");
          $twit_user->twit_count = 0;
          $twit_user->save();
          $twit_user_date = date("Y-m-d");
        }
        if(strtotime($twit_user_date) == strtotime(date("Y-m-d")) && ($twit_user->twit_count <= $found_user->twit_limit || $found_user->twit_limit == -1) && $twit_user->provider == 'twitter'){
          /* Post Twit */
            // $tweet_text = "I have just received a new subscription to my Private Gallery at www.casualstar.uk/users/".urlencode(Auth::user()->username)." #Findom #ExclusiveContent.";
            /* $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);
            print_r($data);exit; */
          $twit_text = "I have just received a New #Tribute.  View my content at www.casualstar.uk/users/".urlencode(Auth::user()->username)."  #Findom #ExclusiveContent.";
          // $twit_text = "Message Received.";
          // Access Token & Secret Token Used
          Twitter::reconfigure([
            'consumer_key'               => getenv('TWITTER_ID'),
            'consumer_secret'            => getenv('TWITTER_SECRET'),
            'token'                      => $twit_user->access_token,
            'secret'                     => $twit_user->access_token_secret,
          ]);
          $newTwitte = ['status' => $twit_text];

          $uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path() . '/img/twit/autoTweetStickerLayout2_1.jpg')]);
          if(!empty($uploaded_media)){
            $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
          }
          $tot_count = $twit_user->twit_count + 1;
          $twitter = Twitter::postTweet($newTwitte);
          $twit_user->twit_count = $tot_count;
          $twit_user->save();
        }
      }
    }
    else if($found_user->social == 0 && $found_user->twit_enable == 1){
      $twit_user = DB::table('user_twit_details')->where('user_id',$found_user->id)->first();
      if($twit_user){
        $user_date = $twit_user->twit_date;
        $twit_user_date = $twit_user->twit_date;
        if($twit_user_date == null){
          $update_twit = DB::table('user_twit_details')->update(['twit_date' => date("Y-m-d"), 'twit_count' => 0])->where('id',$twit_user->id);
          
          /* $twit_user->twit_date = date("Y-m-d");
          $twit_user->twit_count = 0;
          $twit_user->save(); */
          $twit_user_date = date("Y-m-d");
        }else if(strtotime($twit_user_date) < strtotime(date("Y-m-d"))){
          $update_twit = DB::table('user_twit_details')->update(['twit_date' => date("Y-m-d"), 'twit_count' => 0])->where('id',$twit_user->id);
          
          /* $twit_user->twit_date = date("Y-m-d");
          $twit_user->twit_count = 0;
          $twit_user->save(); */
          $twit_user_date = date("Y-m-d");
        }
        
        
        if(strtotime($twit_user_date) == strtotime(date("Y-m-d")) && ($twit_user->twit_count <= $found_user->twit_limit || $found_user->twit_limit == -1) && $twit_user->provider == 'twitter'){
          /* Post Twit */
            // $tweet_text = "I have just received a new subscription to my Private Gallery at www.casualstar.uk/users/".urlencode(Auth::user()->username)." #Findom #ExclusiveContent.";
            /* $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);
            print_r($data);exit; */
          $twit_text = "I have just received a New #Tribute.  View my content at www.casualstar.uk/users/".urlencode(Auth::user()->username)."  #Findom #ExclusiveContent.";
          // $twit_text = "Message Received.";
          // Access Token & Secret Token Used
          Twitter::reconfigure([
            'consumer_key'               => getenv('TWITTER_ID'),
            'consumer_secret'            => getenv('TWITTER_SECRET'),
            'token'                      => $twit_user->access_token,
            'secret'                     => $twit_user->access_token_secret,
          ]);
          $newTwitte = ['status' => $twit_text];

          $uploaded_media = Twitter::uploadMedia(['media' => File::get(public_path() . '/img/twit/autoTweetStickerLayout2_1.jpg')]);
          if(!empty($uploaded_media)){
            $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
          }
          $tot_count = $twit_user->twit_count + 1;
          $twitter = Twitter::postTweet($newTwitte);
          $update_twit = DB::table('user_twit_details')->update(['twit_count' => $tot_count])->where('id',$twit_user->id);
          /* $twit_user->twit_count = $tot_count;
          $twit_user->save(); */
        }
      }
    }

       $mailin = new Mailin('amit.p@aqbsolutions.com', '3T6XbqRwdYcapJ2z');
        $mailin->
        addTo($toEmail , 'CASUAL STAR')->
        setFrom($fromEmail , 'CASUAL STAR')->
        setReplyTo($fromEmail , 'CASUAL STAR')->
        setSubject('CasualStar: Access Granted')->
        setHtml('<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body><h3>Hey: '.$users_name.'</h3><p>'.$mess.'</p><br/><p><strong>Please do not reply to this email.</strong></p><br/><p><strong>Casualstar.uk</strong></p></body></html>');
        $res = $mailin->send();

       }catch(Exception $e){
           // continue;
       }

           }
       }else{
           serviceRequest::destroy($id);
       }
       $mes=Lang::get('messages.seaviceRequestStatusChange');
        if($status==3){
           $mes=Lang::get('messages.deleteSuccess');
       }
      return $this->response('success',$mes , '');  
   } 
    public function getAllServiceRequest($currentPage){    
       if(!Auth::user() || !Auth::user()->id){
           return false;
       }
      $limits = 5;
      $offset = ($currentPage -1) * $limits;
      $service = serviceRequest::with('user')->where('receiver_id',Auth::user()->id);
              
      $ct = $service ->count();        
      $ct = $ct/$limits; 
      $ct_total = $service ->count();        

      $service = $service
              ->orderBy('created_at','DESC')
              ->skip($offset)
              ->take($limits)
              ->get();
      foreach($service as $srv) {
        $srv->created_at_human = $srv->created_at->format('d M Y, g:i:s A');
      }
      $isnext=$ct > ($limits*$currentPage) ? true : false;
      $arr =array('data'=>$service , 'count'=>$ct,'is_nxt'=>$isnext, 'total_count' => $ct_total);
      return $this->response($arr , '' , '');
  }
    
     public function getPendingServiceRequest(){    
       if(!Auth::user() || !Auth::user()->id){
           return false;
       }
     $rest[] = Array();
     $rest['query'] = null;
     $rest['bindings'] = null;
      // DB::enableQueryLog();
      $service = DB::table('service_requests as sr')
              ->selectRaw('sr.*')
              ->where('sr.receiver_id',Auth::user()->id)
              ->where('sr.status','PENDING');
              
      $ct = $service ->count();        
    // $rest = DB::getQueryLog();
      $arr =array('count'=>$ct, 'qry' => $rest);
      return $this->response($arr , '' , '');
  }

  public function checkAccessPeriod(){
      try{
          $service=serviceRequest::where('service_id',10)
                               ->where('status','COMPLETED')
                               ->where(function ($q) {
                    $q->where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id);
                })
                               ->get();
                               $service_arr =array();
              foreach ($service as $key => $value) {
                                $variable_name=$value->variable_name;
                                /*echo date('Y-m-d H:i:s' , strtotime(' -'.$variable_name));
                                echo $value->confirm_date;
*/                                $m = strtotime(date('Y-m-d H:i:s' , strtotime(' -'.$variable_name)));
                                $n = strtotime($value->confirm_date);
                                //dd($n." ".$m);
                                if($n <$m )
                  $service_arr[] = $value->id;
                               } 
              if(count($service_arr) > 0){
                serviceRequest::whereIn('id',$service_arr)->update(['status'=>'EXPIRED']);
              }    
      }
      catch(Exception $e){
         return true;
      }
                  

  }

  public function privateGalleryAccess($username){
    
      $user = User::where('username', $username)->first();
      $log_user = Auth::user();
      $userService=userService::where('user_id',$user->id)->where('service_id',10)->where('status','=',1)->first();
      $iwantaccess=0;
      $accessGranted=0;
      $accessPending=0;
    $timespan = null;
      if($userService&&$userService->id){
        $iwantaccess=$userService->id;
    // APInfo Starts
    
    $Upd_servcie = serviceRequest::where('user_service_id', $userService->id)->where('service_id',10)->where('status', "COMPLETED")->get();
    
    foreach($Upd_servcie as $sv)
    {
      if(trim($sv->variable_name) == "1 day")
      {
        $one_day = strtotime(date("Y-m-d H:i:s"));
        $confirm_date = strtotime(date("Y-m-d H:i:s", strtotime($sv->confirm_date." +1 day")));
        $timespan = $sv->variable_name." ".date("Y-m-d H:i:s", $one_day)." confirm date ".date("Y-m-d H:i:s", $confirm_date)." greater ".($confirm_date <= $one_day). " confirm date <= ".$confirm_date. " today date ".$one_day;
        if($confirm_date <= $one_day){
          serviceRequest::where('service_id',$sv->service_id)->where('user_service_id',$sv->user_service_id)->update(['status'=>'EXPIRED']);
        }
      }
      if(trim($sv->variable_name) == "1 week")
      {
        $one_week = strtotime(date("Y-m-d H:i:s"));
        $confirm_date = strtotime(date("Y-m-d H:i:s", strtotime($sv->confirm_date." +1 week")));
        $timespan = $sv->variable_name." ".date("Y-m-d H:i:s", $one_week)." confirm date ".date("Y-m-d H:i:s", $confirm_date)." greater ".($confirm_date <= $one_week). " confirm date <= ".$confirm_date. " today date ".$one_week;
        if($confirm_date <= $one_week){
          serviceRequest::where('service_id',$sv->service_id)->where('user_service_id',$sv->user_service_id)->update(['status'=>'EXPIRED']);
        }
      }
      if(trim($sv->variable_name) == "1 month")
      {
        $one_month = strtotime(date("Y-m-d H:i:s"));
        $confirm_date = strtotime(date("Y-m-d H:i:s", strtotime($sv->confirm_date." +1 month")));
        $timespan = $sv->variable_name." ".date("Y-m-d H:i:s", $one_month)." confirm date ".date("Y-m-d H:i:s", $confirm_date)." greater ".($confirm_date <= $one_month). " confirm date <= ".$confirm_date. " today date ".$one_month;
        if($confirm_date <= $one_month){
          serviceRequest::where('service_id',$sv->service_id)->where('user_service_id',$sv->user_service_id)->update(['status'=>'EXPIRED']);
        }
      }
    }
    // APInfo Ends
    if($log_user->id == 1 && strtoupper($log_user->email)==strtoupper(trim("casualstar.uk.info@gmail.com"))){
      $accessPending = 0;
      $accessGranted = 1;
    }else{
    
    $service=serviceRequest::where('sender_id',$log_user->id)
         ->where('receiver_id',$user->id)
         ->where('user_service_id',$userService->id)
         ->where('status','COMPLETED')->first();
         if($service&&$service->id){
        $accessGranted=1;
         }
      $service3=serviceRequest::where('sender_id',$log_user->id)
           ->where('receiver_id',$user->id)
           ->where('user_service_id',$userService->id)
           ->where('status','PENDING')->first();
           if($service3&&$service3->id){
          $accessPending=1;
           }
    }
      }

      $userService2=userService::where('user_id',$log_user->id)->where('service_id',10)->first();
      $buttonEnable=0;
      if($userService2&&$userService2->id){
                        $service2=serviceRequest::where('sender_id',$user->id)
                   ->where('receiver_id',$log_user->id)
                   ->where('user_service_id',$userService2->id)
                   ->where('status','PENDING')->first();
                   if($service2&&$service2->id){
                    $buttonEnable=$service2->id;
                   }
      }
       
       $arr =array('accessGranted'=>$accessGranted,'buttonEnable'=>$buttonEnable,'iwantaccess'=>$iwantaccess,'accessPending'=>$accessPending, 'timespan'=>$timespan);
   
       return $this->response($arr, Lang::get('messages.seaviceRequestSave'), '');
   
  }
  
  public function saveNewService() {
    
    /* $user_valid = $this->validate($request,[
      'service_name' => 'required|min:5|max:16',
      'amount' => 'nullable|required|regex:/^\d*(\.\d{1,2})?$/|min:1|max:16',
      'variable_name' => 'required|variable_name|unique:services|min:1|max:16',
    ],[
      'service_name' => 'required|min:5|max:16',
      'amount' => 'nullable|required|regex:/^\d*(\.\d{1,2})?$/|min:1|max:16',
      'variable_name' => 'required|variable_name|unique:services|min:1|max:16',
    'firstname.required' => ' The first name field is required.',
    'firstname.min' => ' The first name must be at least 5 characters.',
    'firstname.max' => ' The first name may not be greater than 35 characters.',
    'lastname.required' => ' The last name field is required.',
    'lastname.min' => ' The last name must be at least 5 characters.',
    'lastname.max' => ' The last name may not be greater than 35 characters.',
    ]); */
    $validator = Validator::make(Input::all(),[
      'service_name' => 'required|min:3|max:16|unique:services,service_name,NULL,id,user_id,'.\Auth::user()->id,
      'variable_name' => 'required|min:3|max:16',
      // 'variable_name' => 'required|min:3|max:16|unique:service_variables,variable_name',
      // 'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/|min:1|max:6',
    ]);
    
    if ($validator->fails()) {
      return $this->response(['errors' => $validator->errors()], '', '');
    }
    
    $res = new \stdClass();
    $service_only= service::insertGetId(
      array(
        'user_id'=> Auth::user()->id,
        'service_name' => Input::get('service_name'),
        'added_time' => date("Y-m-d H:i:s")
      )
    );
    if(count($service_only) > 0)
    {
      $service_user= userService::insertGetId(
        array(
          'user_id'=> Auth::user()->id ,
          'service_id' => $service_only,
          'variable_name' => Input::get('variable_name'),
          'amount' => 0,
          // 'amount' => Input::get('amount'), //can set amount
          'negotiate' => 'false',
          'status' => 0,
        )
      );
      $service_user= serviceVariable::insertGetId(
        array(
          'service_id' => $service_only,
          'variable_name' => Input::get('variable_name'),
        )
      );
      $this->getAllService();
      
      return $this->response(['success' => 1], '', '');
      // return $this->response($service, Lang::get('messages.seaviceSave'), '');
    }else{
      service::where('id', $service_only)->delete();
      // return $this->response(['errors' => $validator->errors()], '', Lang::get('messages.loginServerError'));
      return $this->response(false, Lang::get('messages.loginServerError'), '');
    }
  }
  
  public function updateNewService() {
    $serv_id = Input::get('service_id');
    $validator = Validator::make(Input::all(),[
      'service_name' => 'required|min:3|max:16|unique:services,service_name,'.$serv_id.',id',
      'variable_name' => 'required|min:3|max:16|unique:service_variables,variable_name,'.$serv_id.',service_id'
      // 'amount' => 'required|regex:/^\d*(\.\d{1,2})?$/|min:1|max:6',
    ]);
    
    if ($validator->fails()) {
      $this->getAllService();
      return $this->response(['errors' => $validator->errors()], '', '');
    }
    DB::beginTransaction();
    
    try{
      DB::table('services')->where('id',$serv_id)->update(['service_name'=>Input::get('service_name')]);
      DB::table('service_variables')->where('service_id',$serv_id)->update(['variable_name' => Input::get('variable_name')]);
      DB::table('user_services')->where('service_id',$serv_id)->update([
        'variable_name' => Input::get('variable_name'),
        'amount' => 0,
        'negotiate' => 'false',
        'status' => 0
      ]);
      DB::commit();
    }catch(\Exception $e){
      DB::rollback();
      $this->getAllService();
      return $this->response(false, 'Something Wrong', '');
    }
      
      $this->getAllService();
      return $this->response(['success' => 1], '', '');
    }
    
    public function delNewService() {
    $serv_id = Input::get('service_id');
     
    DB::beginTransaction();
    
    try{
      DB::table('services')->where('id',$serv_id)->delete();
      DB::table('service_variables')->where('service_id',$serv_id)->delete();
      DB::table('user_services')->where('service_id',$serv_id)->delete();
      DB::commit();
    }catch(\Exception $e){
      DB::rollback();
      $this->getAllService();
      return $this->response(false, 'Something Wrong', '');
    }
    $this->getAllService();
    return $this->response(['success' => 1], '', '');
    }
  /* public function wink($username) {
        $user = User::where('username', $username)->first();
        $winkBack = Wink::where('by_user_id', $user->id)->where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->first();
        if($winkBack) {
            $winkBack->replied = 1;
            $winkBack->save();
        }
        
        $winked = Wink::where('by_user_id', Auth::user()->id)->where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();
        
        if($winked) {
            if($winked->replied == 0) {
                return $this->response(false, '' , Lang::get('messages.alreadyWinked'));
            }
        }

        $wink = new Wink();
        $wink->user_id = $user->id;
        $wink->seen = false;
        $wink->by_user_id = Auth::user()->id;
        $wink->replied = 0;
        $wink->save();

        return $this->response($wink, Lang::get('messages.youWinked'), '');
    } */
  
  public function enableTwit(){
        $id = Input::get('id');
        $status = Input::get('statics');
        $flg = Input::get('flgs');
        $user = User::find($id);
    if($flg == "TR")  $user->twit_enable = $status;
    if($flg == "PG")  $user->twit_private_enable = $status;
        $user->save();
    $data = new \stdClass;
    $data->users = $user;
    return $this->response($data, '', '');
    }
  
  public function saveTwitLimit(){
        $id = Input::get('id');
        $status = Input::get('set_limit');
        $flg = Input::get('flgs');
        $user = User::find($id);
    if($flg == "TR")  $user->twit_limit = $status;
    if($flg == "PG")  $user->twit_private_limit = $status;
        $user->save();
    $data = new \stdClass;
    $data->users = $user;
    return $this->response($data, '', '');
    }
}