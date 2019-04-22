<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Carbon\Carbon;
use Input;
use Image;
use Auth;
use Lang;
use Hash;
use Session;
use DB;
use App\Models\User;
use App\competition_user;

class SearchCompetitionUserController extends Controller
{
    public function browse() 
    {

        $userfilters = Session::put('userfilters', Input::all());
        echo "<pre>"; print_r($userfilters); die;
        $page = Input::get('page');
        $perPage = Input::get('perPage');
        $lat = Auth::user()->lat;
        $lng = Auth::user()->lng;
        $user = Auth::user();
		// DB::enableQueryLog();
        $haversine = "(3959 * acos(cos(radians(" . $user->lat . ")) 
                     * cos(radians(lat))    
                     * cos(radians(lng) 
                     - radians(" . $user->lng . ")) 
                     + sin(radians(" . $user->lat . ")) 
                     * sin(radians(lat))))";

        $count = competition_user::select('id')->where('id', '!=', $user->id)->whereNotNull('username');
        echo "<pre>"; print_r($count); die;
        $users = competition_user::select('username', 'img')->where('id', '!=', $user->id)->whereNotNull('username');

		if(Input::get('withAllGender') == "false") {
			if(Input::has('distance'))
			{
				$radius = Input::get('distance');
				$users = $users->whereRaw("{$haversine} < ?", [$radius]);
				$count = $count->whereRaw("{$haversine} < ?", [$radius]);
			}
		}
		
        if(Input::get('userText') != "" && Input::get('userText') != null) {
            $users = $users->where("username","LIKE",Input::get('userText')."%");
            $count = $count->where("username","LIKE",Input::get('userText')."%");
        }
		
		if($user->gender == 'male') {
			$users = $users->where('gender', 'female');
			$count = $count->where('gender', 'female');
		}

		if($user->gender == 'female') {
			$users = $users->where('gender', 'male');
			$count = $count->where('gender', 'male');
		}

        if(Input::get('withImagesOnly') == "true") {
            $users = $users->whereNotNull('img');
            $count = $count->whereNotNull('img');
        }
		
        
        $currentDate = date("Y-m-d");

        if(Input::get('minAge')) {
            $dobYear = explode('-', $currentDate)[0] - Input::get('minAge');
            $users = $users->whereDate('dob', '<=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
            $count = $count->whereDate('dob', '<=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
        }

        if(Input::get('maxAge')) {
            $dobYear = explode('-', $currentDate)[0] - Input::get('maxAge') - 1;
            $users = $users->whereDate('dob', '>=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
            $count = $count->whereDate('dob', '>=', $dobYear . '-' . explode('-', $currentDate)[1] . '-' . explode('-', $currentDate)[2]);
        }

        if(Input::get('lookingFor')) {
            $users = $users->whereHas('interests', function($query)
            {
                $query->whereIn('interest_id', explode(',', Input::get('lookingFor')));
            });
            $count = $count->whereHas('interests', function($query)
            {
                $query->whereIn('interest_id', explode(',', Input::get('lookingFor')));
            });
        }

        if(Input::get('sortBy') == 'created_at') {
            $users = $users->orderBy(Input::get('sortBy'), 'DESC');
        } elseif(Input::get('sortBy') == 'distance') {
            $users = $users->orderBy(Input::get('sortBy'), 'ASC')->orderBy('username', 'ASC');
        }

        if(Input::get('onlineNow') == 'true') {
            $onlineUsers = Online::getOnlineUsers();
            $onlineIds = [];
            foreach($onlineUsers as $user) {
                $onlineIds[] = $user['id'];
            }

            $users = $users->whereIn('id', $onlineIds);
            $count = $count->whereIn('id', $onlineIds);
        }


        $users = $users->limit($perPage)->skip($page * $perPage - $perPage)->get();
        $count = $count->count();

		
        if(Input::get('onlineNow') == 'true') {
            foreach($users as $key => $user) {
                $users[$key]->online = true;
            }
        }

        $data = new \stdClass;
        // $qry = DB::getQueryLog();
        $data->users = $users;
        $data->count = $count;
		// $data->qry = $qry;
        return $this->response($data, $users, $count);

    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            
            $query = $request->get('search');
            if($query != '')
            {   
                $data = DB::table('competition_interested_users')
                        ->select('competition_interested_users.*','competiton_vote.*',DB::raw('count(competiton_vote.id) as total_votes'))
                        ->join('competiton_vote','competiton_vote.user_id','=','competition_interested_users.user_id')
                        ->where('username','like','%'.$query.'%')
                        ->get();
                if($data[0]->competition_id !=''){
                $data = array(
                    'response' => $data
                );
                
                return json_encode($data);
                }
                else
                {
                    $not_found = "Recordnotfound";
                    $data = array(
                    'not_found' => $not_found
                );
                
                return json_encode($data);
                }
            }
            else
            {
               echo "Record not found"; 
            }

        }

        
    }
}
