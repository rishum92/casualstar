<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use DB;
use Auth;
use File;

class competition_user extends Model
{
  public static function getdata()
  {
    $getuserdata = DB::table('competition_interested_users')
                ->select('users.username','competition_interested_users.*', DB::raw('count(competiton_vote.id) as total_votes'))
                ->join('users','id','=','competition_interested_users.user_id')
                ->leftJoin('competiton_vote', 'users.id', '=', 'competiton_vote.user_id')
                ->groupBy('users.id', 'competiton_vote.user_id')
                ->orderBy('total_votes', 'desc')
                ->where('is_status',1)
                ->paginate(20);

    foreach ($getuserdata as $key => $userdata) {
        $comment_count = DB::table('profile_comments')
                          ->select('comment')
                          ->where('competition_id', $userdata->competition_id)
                          ->where('is_deleted',0)
                          ->get(); 

        $getuserdata[$key]->total_comment = count($comment_count);
    }

    //echo '<pre>';print_r($getuserdata);exit;
    return $getuserdata;  
  }
  public static function existuser($user_id)
  {
    $exist =  DB::table('competition_interested_users')
                  ->join('users','id','=','competition_interested_users.user_id')
                  ->where('competition_interested_users.user_id','=',$user_id)
                  ->get();
    //echo "<pre>";print_r($exist);die;
    return $exist;
  }
  public static function updateexpirydate($date,$user_id)
  {
    $insertdate = DB::table('competition_expiry_date')
                ->update(['user_id'=>$user_id,'ExpiryDate'=>$date]);
    return $insertdate;
  }

  public static function confirm_vote($confirm_vote,$voter_id,$competition_userid,$competitionid)
  {
    $insertvote = DB::table('competiton_vote')
                ->insert(['voter_id'=>$voter_id,'is_vote'=>$confirm_vote,'user_id'=>$competition_userid,'competition_id'=>$competitionid]);
    $votecount = DB::table('competiton_vote')
                ->select('is_vote')
                ->where('competition_id',$competitionid)
                ->where('is_vote','=',1)
                ->get();
    return count($votecount);
  }
  public static function vote_count($voter_id)
  {
    $votes = DB::table('competiton_vote')
              ->where('voter_id',$voter_id)
              ->get();
   //echo "<pre>";print_r($votes);die;
    foreach ($votes as $key => $vote) {
      $votes[$key] = $vote->user_id;
    }
    return $votes;
  }
  public static function showdate()
  {
    $showdate = DB::table('competition_expiry_date')
                  ->select('ExpiryDate')
                  ->get();
    return $showdate;  
  }
  public static function termscondition($user_id,$termscondition)
  {
    
    $termscondition = DB::table('competiton_terms_condition')
                   ->update(['user_id'=>$user_id,'termscondition'=>$termscondition]);
    return $termscondition;
  }
  public static function showtermscondition()
  {
    $termscondtion = DB::table('competiton_terms_condition')
                  ->select('termscondition')
                  ->get();
    // if(!empty($termscondition)){
    //   return $termscondtion[0]->termscondition;
    // } else {
    //   return $termscondtion;
    // }
    return $termscondtion[0]->termscondition;
  }
  public static function competitiondelete($competitionid) 
  {
    $username = DB::table('competition_interested_users')
              ->select('username')
              ->where('competition_id', '=', $competitionid)
              ->get();
    $user_name = $username[0]->username;
              DB::table('competition_interested_users')
              ->where('competition_id', '=', $competitionid)
              ->delete();
    if(file_exists('img/competition_user/' .$user_name)) {
      File::deleteDirectory(public_path('img/competition_user/'.$user_name));
    }
  }
  public static function votedelete($competitionid)
  {
    $deletevote = DB::table('competiton_vote')
                  ->where('competition_id','=',$competitionid)
                  ->delete();
  }
  public static function commentdelete($competitionid)
  {
    $deletecomment = DB::table('profile_comments')
                  ->where('competition_id','=',$competitionid)
                  ->delete();
  } 
  public static function update_vote($user)
  {
    $update_vote = DB::table('competiton_vote')
                ->where('voter_id',$user)
                ->update(['is_vote'=>0]);
  }
  public static function delete_account($user)
  {
    $delete_account = DB::table('competition_interested_users')
                    -> where('user_id',$user)
                    ->update(['is_status'=>0]);
  }
  public static function update_amount_edit($vote_amount,$user_id)
  {
    $update_amount = DB::table('competiton_vote')
                    -> where('user_id',$user_id)
                    ->update(['vote_amount'=>$vote_amount]);
    return $update_amount;
  }
  public static function update_title ($edit_title,$user_id)
  {
    $insert_title   = DB::table('competition_expiry_date')
                    ->where('user_id',$user_id)
                    ->update(['competition_title'=>$edit_title]);
  }
  public static function get_title()
  {
    $get_title  = DB::table('competition_expiry_date')
                ->select('competition_title')
                ->get();
    return $get_title[0]->competition_title;
  }
  public static function comment_user_data($user_id)
  {
    $user_data    = DB::table('competition_interested_users')
                  ->select('users.*','competition_interested_users.*')
                  ->join('users','users.id','=','competition_interested_users.user_id')
                  ->where('user_id', '=', $user_id)
                  ->get();
    return $user_data ;
  }
  public static function confirm_comment($comment,$competition_user_id,$competition_id,$user_id,$date)
  {
    $insert_comment = DB::table('profile_comments')
                    ->insert(['competition_id'=>$competition_id,'user_id'=>$competition_user_id,'sender_id'=>$user_id,'comment'=>$comment,'created_at'=>$date,'updated_at'=>$date]);
    $get_comment    = DB::table('profile_comments')
                    ->select('*')
                    ->where('profile_comments.user_id','=',$competition_user_id)
                    ->where('is_deleted',0)
                    ->orderBy('created_at','desc')
                    ->get();
    return $get_comment;
  }
  public static function getcomments($user_id)
  {
    $getcomments =  DB::table('profile_comments')
                    ->select('profile_comments.*','users.username','users.img' )
                    ->join('users','users.id','=','profile_comments.sender_id')
                    ->where('profile_comments.user_id',$user_id)
                    ->where('is_deleted',0)
                    ->orderBy('created_at','desc')
                    ->get();
    return $getcomments;
  }
  public static function deletecomment($comment_id)
  {
    $delete_comment = DB::table('profile_comments')
                    ->where('id',$comment_id)
                    ->update(['is_deleted'=>1]);
  }
  public static function comment_count($competitionid)
  {
    $comment_count  = DB::table('profile_comments')
                    ->select(DB::raw('count(comment) as total_votes'))
                    ->where('competition_id',$competitionid)
                    ->get();
    return $comment_count;
  } 

}
