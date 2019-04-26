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
                        ->select('competition_interested_users.*','competiton_vote.is_vote',DB::raw('count(competiton_vote.is_vote) as total_votes'))
                        ->join('competiton_vote','competiton_vote.user_id','=','competition_interested_users.user_id')
                        ->where('username','like','%'.$query.'%')
                        ->where('is_vote',1)
                        ->get();
                //echo "<pre>";print_r($data);die;
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
