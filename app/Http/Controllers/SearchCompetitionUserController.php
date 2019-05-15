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
use DateTime;
use App\Models\User;
use App\competition_user;

class SearchCompetitionUserController extends Controller
{
    public function action(Request $request)
    {
        $username = Auth::user()->username;
        if ($request->ajax()) {
            
            $query = $request->get('search');
            if($query != '')
            {   
                $showdate = competition_user::showdate();
                $data = DB::table('competition_interested_users')
                        ->select('competition_interested_users.*','users.*')
                        ->join('users','id','=','competition_interested_users.user_id')
                        ->where('competition_interested_users.username','like','%'.$query.'%')
                        ->where('competition_interested_users.is_status',1)
                        ->get();
                foreach ($data as $key => $vote_data) 
                {
                    $vote_count = DB::table('competiton_vote')
                                ->select('is_vote')
                                ->where('competition_id', $vote_data->competition_id)
                                ->where('is_vote',1)
                                ->orderBy('is_vote', 'asc')
                                ->get(); 

                    $data[$key]->total_votes = count($vote_count);
                }
                foreach($data as $key =>$comment_data)
                {
                    $comment_count = DB::table('profile_comments')
                                ->select('comment')
                                ->where('competition_id', $comment_data->competition_id)
                                ->where('is_deleted',0)
                                ->get(); 

                    $data[$key]->total_comment = count($comment_count);
                }
                foreach($data as $key =>$vote_amount)
                {
                    $vote_amount = DB::table('competiton_vote')
                                ->select('vote_amount')
                                ->where('competition_id', $vote_amount->competition_id)
                                ->get(); 

                    $data[$key]->vote_amount = $vote_amount;
                }
                foreach($data as $key =>$user_position)
                {
                    $position = DB::table('competiton_vote')
                                ->select('user_position')
                                ->where('competition_id', $user_position->competition_id)
                                ->get(); 

                    $data[$key]->user_position = $position;
                }
                $showdate   =   DB::table('competition_expiry_date')
                                    ->select('ExpiryDate')
                                    ->get();
                foreach ($data as $key => $voter_count) {
                    $votes  =   DB::table('competiton_vote')
                                ->where('voter_id',$voter_count->user_id)
                                ->get();
                    $data[$key]->voter_count = $votes;
                    $data[$key]->total_voters_count = count($votes);
                foreach ($votes as $key => $vote) {
                    $votes[$key] = $vote->user_id;
                   }
                    
                }
                 
                //echo "<pre>";print_r($data);die;
                if(!empty($data))
                {
                    $data = array(
                        'response' => $data,
                        'showdate' => $showdate,
                        'username' => $username
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
    // competiton_vote.is_vote',DB::raw('count(competiton_vote.is_vote) as total_votes// ->where('is_vote',1)
    // join('competiton_vote','competiton_vote.user_id','=','competition_interested_users.user_id')
    //  public function action(Request $request)
    // {
    //     if ($request->ajax()) {
            
    //         $query = $request->get('search');
    //         if($query != '')
    //         {
    //             $data = DB::table('users')
    //                     ->where('username','like','%'.$query.'%')
    //                     ->select('*')
    //                     ->get();
    //             $data = array(
    //                 'response' => $data
    //             );
                
    //             return json_encode($data);
    //         }
    //         else
    //         {
    //            echo "Record not found"; 
    //         }
// res[i].total_voters_count < 2 && (jQuery.inArray(res[i].user_id, res[i].voter_count)!='-1') && res[i].user_id != auth_userid || obj.username == 'Admin' && new_date_format != newexpirydate
    //     }

        
    // }
}
