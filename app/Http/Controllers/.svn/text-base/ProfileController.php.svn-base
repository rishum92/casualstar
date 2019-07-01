<?php
//
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use App;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Chat;
use App\Models\User;
use App\Models\ProfileView;
use App\Models\Wink;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Interest;
use Mail;

class ProfileController extends BaseController
{
  public function dashboard() {
    if(Session::get('filters')) {
      $filters = Session::get('filters');
      if(isset($filters['lookingFor'])) {
        $lookingForInterests = Interest::whereIn('id', explode(',', $filters['lookingFor']))->get();
        $filters['lookingForInterests'] = $lookingForInterests;
      }
    } else {
      $filters = [];
    }
    $filters = json_encode($filters);
    return view('dashboard', ['filters' => $filters]);
  }

  public function messages($username = null) {
    $plans = Plan::all();
    $me = User::find(Auth::user()->id);
    $orders = Order::where('user_id', Auth::user()->id)->where('status', 1)->with('plan')->get();
    $activeOrders = $orders->filter(function ($item) {
        return $item->created_at->gt(Carbon::now()->subMonth($item->plan->period));
    });
    $orders = $activeOrders->all();

    if(count($orders) == 0 && $me->gender == 'male') {
      $subscribed = 0;
    } else {
      $subscribed = 1;
    }
    if(!is_null($username)) {
      $user = User::select('username','id','status','img','gender')->where('username', $username)->first();
      if($user && $user->status == 1) {
        $chat = Chat::where('ids', 'all', [Auth::user()->id, $user->id])->orderBy('created_at', 'DESC')->first();
        if(!is_null($chat)) {
          $oldDeleted = $chat->deleted;
          $newDeleted = [];
          if(in_array($user->id, $oldDeleted) && in_array(Auth::user()->id, $oldDeleted)) {
            $chat = new \stdClass;
            $chat->_id = 'new';
            $chat->ids = [Auth::user()->id, $user->id];
            $chat->messages = [];
            if(!$user->img) {
              $user->img = '../../../' . $user->gender . '.jpg';
            }
            $chat->partner = $user;
            $chat->unread = 0;
            
            // $MongoDt = new \MongoDate();
            // $stringDt =
            //    substr(
            //       (new \DateTime())
            //        ->setTimestamp($MongoDt->sec)
            //        ->setTimeZone(new \DateTimeZone('UTC'))
            //        ->format(\DateTime::ISO8601),
            //    0, -5).sprintf('.%03dZ', $MongoDt->usec / 1000);
            // $chat->created_at = $stringDt;
            // $chat->updated_at = $stringDt;
            $chat->deleted = [];
          } else {
            foreach($chat->deleted as $key => $deleted) {
              if($deleted !== Auth::user()->id) {
                $newDeleted[] = $deleted;
              }
            }
            $chat->deleted = $newDeleted;
            $chat->save();
          }
        } else {
          $chat = new \stdClass;
          $chat->_id = 'new';
          $chat->ids = [Auth::user()->id, $user->id];
          $chat->messages = [];
          if(!$user->img) {
            $user->img = '../../../' . $user->gender . '.jpg';
          }
          $chat->partner = $user;
          $chat->unread = 0;
          
          // $MongoDt = new \MongoDate();
          // $stringDt =
          //    substr(
          //       (new \DateTime())
          //        ->setTimestamp($MongoDt->sec)
          //        ->setTimeZone(new \DateTimeZone('UTC'))
          //        ->format(\DateTime::ISO8601),
          //    0, -5).sprintf('.%03dZ', $MongoDt->usec / 1000);
          // $chat->created_at = $stringDt;
          // $chat->updated_at = $stringDt;
          $chat->deleted = [];
          // $chat->save();

          // $toEmail = $user->email;
          // $name = 'CasualStar';
          // $fromEmail = 'info@casualstar.uk';

          // Mail::send('emails.newchat', ['user' => Auth::user()], function($email) use($name, $fromEmail, $toEmail) {
          //   $email->from($fromEmail, $name)->to($toEmail)->subject('CasualStar: New chat');
          // });
        } 
        return view('messages', ['chatId' => $chat->_id, 'chat' => json_encode($chat), 'subscribed' => $subscribed, 'plans' => $plans]);
      } else {
        return redirect()->back()->with('message', 'This user has been banned.')->with('messageType','danger');
      }
    } else {
      return view('messages', ['chatId' => NULL, 'chat' => json_encode(new \stdClass), 'subscribed' => $subscribed, 'plans' => $plans]);
    }
  }

  public function profile() {
    $user = Auth::user();
    return view('profile', ['user' => $user, 'username' => $user->username]);
  }

  public function activity() {
    $profileViews = ProfileView::where('user_id', Auth::user()->id)->where('seen', 0)->get();
    foreach($profileViews as $profileView) {
      $oldDate = $profileView->updated_at;
      $profileView->timestamps = false;
      $profileView->seen = true;
      $profileView->save();
    }
    Wink::where('user_id', Auth::user()->id)->update(['seen' => true]);
     
    return view('activity', []);
  }

  public function settings() {
    return view('settings', []);
  }
  
  public function verify() {
    $user = Auth::user();
	return view('verifyProfile', ['user' => $user, 'username' => $user->username]);
  }  

}
