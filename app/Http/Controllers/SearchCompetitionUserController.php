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
    public function action(Request $request)
    {
        
        if ($request->ajax()) {
            
            $query = $request->get('search');
            if($query != '')
            {   
                $data = DB::table('competition_interested_users')
                        ->select('competition_interested_users.*')
                        ->where('username','like','%'.$query.'%')
                        ->where('is_status',1)
                        ->get();
                foreach ($data as $key => $vote_data) 
                {
                    $vote_count = DB::table('competiton_vote')
                                ->select('is_vote')
                                ->where('competition_id', $vote_data->competition_id)
                                ->where('is_vote',1)
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
                //echo "<pre>";print_r($data);
                if(!empty($data))
                {
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

    //     }

        
    // }
}
