<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App;
use Carbon\Carbon;
use Auth;
use Session;
use Mail;
use Input;
use App\Models\User;
use App\Models\Photo;
use App\Models\Order;
use App\Models\BannerAd;
use App\Models\BannerAdRequest;
use App\Models\Competitions;
use DB;
use App\Models\Cms;

class AdminController extends Controller
{
    public function index() {
        return view('admin.index', []);
    }
	
    public function subscriptions() {
        $page = Input::get('page');
        $perPage = Input::get('perPage');

        $count = Order::where('status', 1)->with('plan')->get();
        $activeOrdersCount = $count->filter(function ($item) {
            $item->user = User::find($item->user_id);
            $item->expires_at = $item->created_at->addMonth($item->plan->period);
            return $item->created_at->gt(Carbon::now()->subMonth($item->plan->period));
        });

        $orders = Order::where('status', 1)->with('plan')->limit($perPage)->skip($page * $perPage - 20)->get();
        $activeOrders = $orders->filter(function ($item) {
            $item->user = User::find($item->user_id);
            $item->expires_at = $item->created_at->addMonth($item->plan->period);
            return $item->created_at->gt(Carbon::now()->subMonth($item->plan->period));
        });
        $orders = $activeOrders->all();

        $data = new \stdClass;
        $data->subscriptions = $orders;
        $data->count = $activeOrdersCount->count();

        return $this->response($data, '', '');
    }

    public function totalUsers() {
        return User::count();
    }

    public function users() {
        $page = Input::get('pageUsers');
        $perPage = Input::get('perPageUsers');

        $count = User::where('id', '>', -1);
        $users = User::where('id', '>', -1)->limit($perPage)->skip($page * $perPage - $perPage);

        if(!is_null(Input::get('genderFemale')) && !is_null(Input::get('genderMale'))) {

        } else {
            if(!is_null(Input::get('genderFemale'))) {
                $users = $users->where('gender', 'female');
                $count = $count->where('gender', 'female');
            }

            if(!is_null(Input::get('genderMale'))) {
                $users = $users->where('gender', 'male');
                $count = $count->where('gender', 'male');
            }
        }

        if(!is_null(Input::get('searchUsers')) && Input::get('searchUsers') !== "") {
            $users = $users->where('username', 'LIKE', '%' . Input::get('searchUsers') . '%');
            $count = $count->where('username', 'LIKE', '%' . Input::get('searchUsers') . '%');
        }
		
		$users = $users->whereNotNull('username');
		$count = $count->whereNotNull('username');
        
		$users = $users->orderBy('created_at', 'ASC')->get();

        // $users = $users->filter(function ($user) {
        //     $orders = Order::where('user_id', $user->id)->where('status', 1)->with('plan')->get();
        //     $user->orders = $orders;
        //     return $user->orders->count() > 0;
        // });

        // dd($users);
        // // foreach($users as $user) {
            
        // //     $orders = $activeOrders->all();
        // //     $user->orders = $orders;
        // // }

        $count = $count->count();

        $data = new \stdClass;
        $data->users = $users;
        $data->count = $count;

        return $this->response($data, '', '');
    }

    public function emailUser() {
        $user = User::find(Input::get('user_id'));
        $toEmail = $user->email;
        $subject = Input::get('subject');
        $name = 'CasualStar';
        $fromEmail = 'casualstar.uk.info@gmail.com';

        $sendEmail = Mail::send('emails.emailUser', ['messageText' => Input::get('message')], function($email) use($name, $fromEmail, $toEmail, $subject) {
            $email->from($fromEmail, $name)->to($toEmail)->subject($subject);
        });
        
        return $this->response($sendEmail, 'E-mail sent.', 'E-mail not sent.');
    }

    public function deleteSubscription($id) {
        $order = Order::find($id);
        $order->delete();

        return $this->response($order, 'Subscription cancelled.', 'Subscription not cancelled.');
    }

    public function deletePhoto($id) {
        $photo = Photo::find($id);
        $photo->hidden = 1;
        $photo->save();

        return $this->response($photo, 'Photo removed from Explore page.', 'Photo could not be removed from Explore page.');
    }

  	public function lockUser() {
        $id = Input::get('id');
        $user = User::find($id);
        $user->status = -1;
        $user->save();
    }

    public function unlockUser() {
        $id = Input::get('id');
        $user = User::find($id);
        $user->status = 1;
        $user->save();
    }
	
	public function index2() {
        $pageUsers = 1;
        if(Session::has('pageUsers')) {
            $pageUsers = Session::get('pageUsers');
        }
        return view('admin.admin2', ['pageUsers' => $pageUsers]);
    }

    public function bannerAds() {
        return view('admin.bannerAds', []);
    }

    public function bannerAdsList() {
        return App\Models\BannerAd::where('created_at', '>', (new Carbon())->addMonths(-3))->whereHas('request', function($q) {
            $q->where('status', 'active');
        })->get();
    }

    public function bannerAdRequestsList() {
        $page = Input::get('pageBannerAdRequests');
        $perPage = Input::get('perPageBannerAdRequests');

        $bannerAdRequests = BannerAdRequest::where('status', 'review')
            ->where('created_at', '>', (new Carbon())->addMonths(-3))
            ->with('user')
            ->with('bannerAdResources')
            ->with(['bannerAds' => function ($q) {
                $q->orderBy('day', 'ASC');
            }])
            ->orderBy('created_at', 'DESC')
            ->limit($perPage)
            ->skip($page * $perPage - $perPage)->get();
        $count = BannerAdRequest::where('status', 'review')->count();

        $data = new \stdClass;
        $data->bannerAdRequests = $bannerAdRequests;
        $data->count = $count;

        return $this->response($data, '', '');
    }

    public function activeBannerAdRequestsList() {
        $page = Input::get('pageActiveBannerAdRequests');
        $perPage = Input::get('perPageActiveBannerAdRequests');

        $bannerAdRequests = BannerAdRequest::where('status', 'active')
            ->with('user')
            ->whereHas('bannerAds', function($q)
            {
                $q->where('day', '>=', date('Y-m-d'));

            })
            ->with('bannerAdResources')
            ->with(['bannerAds' => function ($q) {
                $q->orderBy('day', 'ASC');
            }])
            ->orderBy('created_at', 'DESC')
            ->limit($perPage)
            ->skip($page * $perPage - $perPage)->get();
        $count = BannerAdRequest::where('status', 'active')->whereHas('bannerAds', function($q)
        {
            $q->where('day', '>=', date('Y-m-d'));

        })->count();

        $data = new \stdClass;
        $data->bannerAdRequests = $bannerAdRequests;
        $data->count = $count;

        return $this->response($data, '', '');
    }

    public function approveVideoBannerAdRequest() {
        $bannerAdRequestId = Input::get('banner_ad_request_id');
        $resource = Input::get('resource');

        $bannerAdRequest = BannerAdRequest::find($bannerAdRequestId);
        $bannerAdRequest->status = 'active';
        $bannerAdRequest->save();
        unlink(public_path() . '/banner-ads-resources/videos/' . $bannerAdRequest->bannerAdResources[0]->resource);
        $bannerAdRequest->bannerAdResources[0]->resource = $resource;
        $bannerAdRequest->bannerAdResources[0]->save();

        $this->emailBannerAdRequestStatusUpdate($bannerAdRequest, 'approved', null);

    }

    public function approveBannerAdRequest() {
        $bannerAdRequestId = Input::get('banner_ad_request_id');
        $bannerAdRequest = BannerAdRequest::find($bannerAdRequestId);
        $bannerAdRequest->status = 'active';
        $bannerAdRequest->save();

        $this->emailBannerAdRequestStatusUpdate($bannerAdRequest, 'approved', null);
    }

    public function denyBannerAdRequest($type = 'denied') {
        $bannerAdRequestId = Input::get('banner_ad_request_id');
        $reason = Input::get('reason');

        $bannerAdRequest = BannerAdRequest::find($bannerAdRequestId);
        $bannerAdRequest->status = 'denied';
        $bannerAdRequest->save();

        foreach($bannerAdRequest->bannerAds as $bannerAd) {
            $bannerAd->delete();
        }

        $this->emailBannerAdRequestStatusUpdate($bannerAdRequest, $type, $reason);

        $this->cleanBannerAdRequestFiles($bannerAdRequest);
    }

    public function removeBannerAd() {
        $bannerAdRequestId = Input::get('banner_ad_request_id');
        $bannerAdRequest = BannerAdRequest::find($bannerAdRequestId)->with('bannerAds')->first();

        $this->denyBannerAdRequest('removed');
    }

    private function emailBannerAdRequestStatusUpdate($bannerAdRequest, $type, $reason) {
        $user = User::find($bannerAdRequest->user_id);
        $toEmail = $user->email;
        $subject = 'Banner ad ' . ($type != 'removed' ? 'request ' : '') . $type;
        $name = 'CasualStar';
       $fromEmail = 'casualstar.uk.info@gmail.com';

        Mail::send('emails.bannerAdRequestUpdate', ['reason' => $reason, 'type' => $type, 'bannerAdRequest' => $bannerAdRequest], function($email) use($name, $fromEmail, $toEmail, $subject) {
            $email->from($fromEmail, $name)->to($toEmail)->cc($fromEmail)->subject($subject);
        });
    }

    private function cleanBannerAdRequestFiles($bannerAdRequest) {
        if($bannerAdRequest->type == 'video') {
            $file = public_path() . '/banner-ads-resources/videos/' . $bannerAdRequest->bannerAdResources[0]->resource;
            if(file_exists($file)) {
                unlink($file);
            }
        } else {
            foreach($bannerAdRequest->bannerAdResources as $bannerAdResource) {
                $file = public_path() . '/banner-ads-resources/images/' . $bannerAdResource->resource;
                if(file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }
	
	public function approveUserData() {
        $id = Input::get('id');
        $user = User::find($id);
        $user->verify_check = "VERIFIED";
        $user->verify_created_at = date("Y-m-d H:i:s");
        $user->save();
    }
	
	
	public function cancelUserData() {
        $id = Input::get('id');
        $user = User::find($id);
        $user->verify_check = "CANCELLED";
        $user->verify_created_at = date("Y-m-d H:i:s");
        $user->uploaded_at = null;
        $user->save();
    }
	
	
	public function deleteSelfiePhoto() {
		$id = Input::get('id');
        $user = User::find($id);
        unlink('img/Verified/users/' . $user->username . '/' . $user->verify_img);
        $user->verify_img = NULL;
        $user->verify_check = 'None';
        $user->verify_created_at = NULL;
        $user->uploaded_at = NULL;
        $user->save();
    }
	
	public function notesUserData() {
        $id = Input::get('id');
        $notes = Input::get('note');
        $user = User::find($id);
        $user->text_notes = $notes;
        $user->save();
    }
	
	public function admin_users() {
        $page = Input::get('pageUsers');
        Session::put('pageUsers', $page);
        $perPage = Input::get('perPageUsers');

        $count = User::where('id', '>', -1);
        $users = User::where('id', '>', -1)->limit($perPage)->skip($page * $perPage - $perPage);

        if(!is_null(Input::get('genderFemale')) && !is_null(Input::get('genderMale'))) {

        } else {
            if(!is_null(Input::get('genderFemale'))) {
                $users = $users->where('gender', 'female');
                $count = $count->where('gender', 'female');
            }

            if(!is_null(Input::get('genderMale'))) {
                $users = $users->where('gender', 'male');
                $count = $count->where('gender', 'male');
            }
        }

        if(!is_null(Input::get('searchUsers')) && Input::get('searchUsers') !== "") {
            $users = $users->where('username', 'LIKE', '%' . Input::get('searchUsers') . '%');
            $count = $count->where('username', 'LIKE', '%' . Input::get('searchUsers') . '%');
        }

		$users = $users->where('verify_check','!=','None');
		$count = $count->where('verify_check','!=','None');
		
		$users = $users->whereNotNull('username');
		$count = $count->whereNotNull('username');
        
        $users = $users->orderByRaw("FIELD(verify_check , 'PENDING', 'CANCELLED', 'VERIFIED') ASC")->get();

        // $users = $users->filter(function ($user) {
        //     $orders = Order::where('user_id', $user->id)->where('status', 1)->with('plan')->get();
        //     $user->orders = $orders;
        //     return $user->orders->count() > 0;
        // });

        // dd($users);
        // // foreach($users as $user) {
            
        // //     $orders = $activeOrders->all();
        // //     $user->orders = $orders;
        // // }

        // $count = $users->orderByRaw("FIELD(verify_check , 'PENDING', 'CANCELLED', 'VERIFIED') ASC")->count();
		$count = $count->count();
        $data = new \stdClass;
        $data->users = $users;
        $data->count = $count;

        return $this->response($data, '', '');
    }
    
    /** Compition Function */
    public function compitions(){
        return view('admin.compitions', []);
    }
    
        public function getCompitions(){
        $page = Input::get('pageUsers');
        $perPage = Input::get('perPageUsers');
        $todayDate=date('Y-m-d');
        $compition = DB::table('competitions')->where('deleted_at','=',NULL);
        $count=$compition->count();
        $compition->limit($perPage)->skip($page * $perPage - $perPage);
        $compitions = $compition->orderBy('id', 'DESC')->get();
        $data = new \stdClass;
        $data->compitions = $compitions;
        $data->count =$count;
        return $this->response($data, '', '');
    }
    public function competitionSave() {
        $response = new \stdClass();
        $compition = Competitions::add(Input::all());
        if($compition){
            $response->new = $compition;
            $response->messageType = 'success';
            $response->message = 'Compition Created.';
        } else {
            $response->new = false;
            $response->messageType = 'danger';
            $response->message = Lang::get('messages.admin.addError');
        }    
        return response()->json($response);
    }

    public function competitionEdit(){
        $response = new \stdClass();
        $input = Input::all();
        $Compition = Competitions::find($input['compition_id']);
        $Compition->expiry_date=$input['expiry_date'];
        $Compition->title=$input['title'];
        $Compition->sub_title=$input['sub_title'];
        $Compition->price=$input['price'];
        $Compition->save();
        if($Compition){
            $response->messageType = 'success';
            $response->message = 'Compition Edited.';
            
        }else{
            $response->messageType = 'danger';
            $response->message = 'Compition not Edited.';
        }
        return response()->json($response);
    }

    public function compition_users(){
        return view('admin.compition_users', []);
    }
    public function deleteCompition($id){
        $compition = Competitions::find($id);
        $compition->delete();
        return $this->response($compition, 'Compition deleted.', 'Compition not deleted.');
    }

    public function getcompitionuser($id){
       // echo Input::get('searchUsers');die;
        $page = Input::get('pageCompitionUsers');
        $perPage = Input::get('perCompitionUsers');
        $Cuser = DB::table('competition_users')->join('users', 'users.id','=','competition_users.user_id')->join('competitions','competitions.id','=','competition_users.competition_id')->select('users.id', 'users.email','users.username','users.gender','users.status','competitions.id','competitions.title','competitions.id','competition_users.id','competition_users.user_id','competition_users.created_at')->where('competitions.id','=',$id);
        $count=$Cuser->count();
        if(!is_null(Input::get('genderFemale')) && !is_null(Input::get('genderMale'))) {

        } else {
            if(!is_null(Input::get('genderFemale'))) {
                $compition_user = $Cuser->where('users.gender', 'female');
                $count = $Cuser->where('users.gender', 'female')->count();
            }

            if(!is_null(Input::get('genderMale'))) {
                $compition_user = $Cuser->where('users.gender', 'male');
                $count = $Cuser->where('users.gender', 'male')->count();
            }
        }

        if(!is_null(Input::get('searchUsers')) && Input::get('searchUsers') !== "" && Input::get('searchUsers') !="undefined") {
            $compition_user=$Cuser->where('users.username', 'LIKE', '%' . Input::get('searchUsers') . '%');
            $count = $Cuser->where('users.username', 'LIKE', '%' . Input::get('searchUsers') . '%')->count();
        }

        $Cuser->limit($perPage)->skip($page * $perPage - $perPage);
        $compitionUserList = $Cuser->get();
        $data = new \stdClass;
        $data->compitionUserList = $compitionUserList;
        $data->count = $count;
        return $this->response($data, '', '');
    }

    public function termsCondition() {
        return view('admin.termsCondition');
    }

    public function addTermsCondition() {
       $data = Input::get();
       $newterms=Cms::create([
           'title' => $data['title'],
           'description'=> $data['description']
       ]); 
       $response = new \stdClass();
       if($newterms) {
            $response->new = $newterms;
            $response->messageType = 'success';
            $response->message = 'Added Successfully.';
        } else {
            $response->new = false;
            $response->messageType = 'danger';
            $response->message = Lang::get('messages.admin.addError');
        }
    
        return response()->json($response);
    }
    
    public function listTermsCondition() {
        $cms =  DB::table('cms')->get();
        return $cms;
    }

    public function editTermsCondition(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->input('post');
            if(!empty($data['title'])) {
                DB::table('cms')->where('id', $data['id'])
                ->update([
                    'title' => $data['title'],
                    'description' => $data['description']
                ]);
            } else {
                http_response_code(400);
                echo json_encode(['errors' => ["Title Field is required"]]);
            }
        } 
    }
}
