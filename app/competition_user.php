<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use DB;
use Auth;
use File;

class competition_user extends Model
{
  
  //add new competion user
  public static function insert_competition_user($user_id,$profilePhotoFile)
  {
    $get_user_data  = DB::table('competition_interested_users')
                      ->select('users.*','competition_interested_users.*')
                      ->join('users','id','=','competition_interested_users.user_id')
                      ->groupBy('users.id', 'competition_interested_users.user_id')
                      ->get();
    
    if(empty($get_user_data)){
      $insert_users =  DB::table('competition_interested_users')
                      ->insert(['user_position'=>1,'user_id'=>$user_id, 'user_profile'=>$profilePhotoFile]);
      $select_competition_id  = DB::table('competition_interested_users')
                                ->select('competition_id')
                                ->get();
      $insert_position = DB::table('competiton_vote')
                        ->insert(['is_vote'=>0,'competition_id'=>$select_competition_id[0]->competition_id]);
    }
    else{
      $select_position = DB::table('competition_interested_users')
                        ->select('user_position')
                        ->orderBy('user_position','DESC')
                        ->first();

      $position_of_user = $select_position->user_position;
      if($position_of_user == $select_position->user_position)
      {
        $position_of_user++;
      }
      
      $insert_user =  DB::table('competition_interested_users')
                       ->insert(['user_position'=>$position_of_user,'user_id'=>$user_id, 'user_profile'=>$profilePhotoFile]);

      $select_user_last_id =  DB::getPdo()->lastInsertId();
      $insert_position = DB::table('competiton_vote')
                        ->insert(['is_vote'=>0,'competition_id'=>$select_user_last_id]);
    }  
  }

  //fetch the user data
  public static function get_data()
  {
    $get_user_data  = DB::table('competition_interested_users')
                      ->select('users.*','competiton_vote.*','competition_interested_users.*', DB::raw('count(competiton_vote.is_vote) as total_votes'))
                      ->join('users','id','=','competition_interested_users.user_id')
                      ->leftJoin('competiton_vote', 'competition_interested_users.competition_id', '=', 'competiton_vote.competition_id')
                      ->groupBy('users.id', 'competition_interested_users.user_id')
                      ->orderBy('total_votes','DESC')
                      ->where('is_status',1)
                      ->paginate(20);

     //vote count of each post
     foreach ($get_user_data as $key => $user_vote) {
      $vote_counts  = DB::table('competiton_vote')
                      ->select('is_vote')
                      ->where('competiton_vote.competition_id', $user_vote->competition_id)
                      ->where('is_vote','=',1)
                      ->get(); 
      $get_user_data[$key]->total_votes = count($vote_counts);
    }
    //comment count of each post
    foreach ($get_user_data as $key => $user_comment) {
      $comment_count  = DB::table('profile_comments')
                        ->select('comment')
                        ->where('competition_id', $user_comment->competition_id)
                        ->where('is_deleted',0)
                        ->get(); 
      $get_user_data[$key]->total_comment = count($comment_count);
    }
    //vote prize of each post
    foreach ($get_user_data as $key => $vote_prize) {
      $vote_prize  = DB::table('competition_interested_users')
                    ->select('vote_amount')
                    ->where('competition_id', $vote_prize->competition_id)
                    ->first(); 
      $get_user_data[$key]->vote_prize = $vote_prize;
    }
    return $get_user_data;
  }
    
  //exist user
  public static function is_user_exist($user_id)
  {
    $user_exist  =  DB::table('competition_interested_users')
                    ->join('users','id','=','competition_interested_users.user_id')
                    ->where('competition_interested_users.user_id','=',$user_id)
                    ->where('is_status',1)
                    ->get();
    return $user_exist;
  }

  //update the competition expiry date
  public static function update_expiry_date($date,$user_id)
  {
    $update_date = DB::table('competition_expiry_date')
                  ->update(['user_id'=>$user_id,'ExpiryDate'=>$date]);
    return $update_date;
  }

  //add vote
  public static function confirm_vote($confirm_vote,$voter_id,$competition_userid,$competition_id)
  {
    DB::table('competiton_vote')
    ->insert(['voter_id'=>$voter_id,'is_vote'=>$confirm_vote,'competition_id'=>$competition_id]);
    
    $get_all_user_data = DB::table('competition_interested_users')
                        ->select('users.*','competiton_vote.*','competition_interested_users.*', DB::raw('count(competiton_vote.is_vote) as total_votes'))
                        ->join('users','id','=','competition_interested_users.user_id')
                        ->leftJoin('competiton_vote', 'competition_interested_users.competition_id', '=', 'competiton_vote.competition_id')
                        ->groupBy('users.id', 'competition_interested_users.user_id')
                        ->orderBy('total_votes', 'desc')
                        ->where('is_status',1)
                        ->get();
                      
    $vote_rank  = 0; 
    $temp_vote  = 0;
    foreach ($get_all_user_data as $key => $get_user_id_for_position) {
      if($temp_vote != $get_user_id_for_position->total_votes)
      {
        $vote_rank++;
        $temp_vote = $get_user_id_for_position->total_votes;
      }
      DB::table('competition_interested_users')
      ->where('competition_id',$get_user_id_for_position->competition_id)
      ->update(['user_position'=>$vote_rank]);
    }
    return $get_all_user_data;
  }

  //count voter
  public static function vote_count($voter_id)
  {
    $votes  = DB::table('competiton_vote')
              ->where('voter_id',$voter_id)
              ->get();
    foreach ($votes as $key => $vote) {
      $votes[$key] = $vote->competition_id;
    }
    return $votes;
  }
  
  //exist voters
  public static function exist_voters($voter_id)
  {
    $exist_voter_id = DB::table('competiton_vote')
                      ->select('competition_id')
                      ->where('voter_id',$voter_id)
                      ->get();
    return $exist_voter_id;
  }

  //show competition expiry date
  public static function show_date()
  {
    $show_date = DB::table('competition_expiry_date')
                ->select('ExpiryDate')
                ->get();
    return $show_date;  
  }

  //update the terms and condition
  public static function terms_condition($user_id,$terms_condition)
  {
    $terms_condition =  DB::table('competiton_terms_condition')
                        ->update(['user_id'=>$user_id,'termscondition'=>$terms_condition]);
    return $terms_condition;
  }

  //show the terms and condition
  public static function show_terms_condition()
  {
    $show_terms_condition = DB::table('competiton_terms_condition')
                            ->select('termscondition')
                            ->get();
    return $show_terms_condition[0]->termscondition;
  }

  //delete the competition account and folder of user
  public static function delete_competition($competition_id) 
  { 
    $user_name = DB::table('competition_interested_users')
                ->select('users.*','competition_interested_users.*')
                ->join('users','users.id','=','competition_interested_users.user_id')
                ->where('competition_interested_users.competition_id', '=', $competition_id)
                ->get();
    $delete_user_name =  $user_name[0]->username;
                  DB::table('competition_interested_users')
                  ->where('competition_id', '=', $competition_id)
                  ->delete();
    if(file_exists('img/competition_user/' .$delete_user_name)) {
      File::deleteDirectory(public_path('img/competition_user/'.$delete_user_name));
    }
  }

  //delete vote
  public static function delete_vote($competition_id)
  { 
    $delete_vote =  DB::table('competiton_vote')
                    ->where('competition_id',$competition_id)
                    ->delete();

    $get_all_user_data = DB::table('competition_interested_users')
                        ->select('users.*','competiton_vote.*','competition_interested_users.*', DB::raw('count(competiton_vote.is_vote) as total_votes'))
                        ->join('users','id','=','competition_interested_users.user_id')
                        ->leftJoin('competiton_vote', 'competition_interested_users.competition_id', '=', 'competiton_vote.competition_id')
                        ->groupBy('users.id', 'competition_interested_users.user_id')
                        ->orderBy('total_votes', 'desc')
                        ->where('is_status',1)
                        ->get();
                        
    $vote_rank  = 0; 
    $temp_vote  = 0;
    foreach ($get_all_user_data as $key => $update_position_when_delete) {
      if($temp_vote != $update_position_when_delete->total_votes)
      {
        $vote_rank++;
        $temp_vote = $update_position_when_delete->total_votes;
      }
      DB::table('competition_interested_users')
      ->where('competition_id',$update_position_when_delete->competition_id)
      ->update(['user_position'=>$vote_rank]);
    } 
    
    return $get_all_user_data;
    
  }

  //delete comment
  public static function delete_comment($competition_id)
  {
    DB::table('profile_comments')
    ->where('competition_id','=',$competition_id)
    ->delete();
  } 

  //update the vote when the account is deleted  
  public static function update_vote($user_id)
  {
    DB::table('competiton_vote')
    ->where('voter_id',$user_id)
    ->update(['is_vote'=>0]);
  }

  //delete the competition account when account is deactivated
  public static function delete_account($user_id)
  {
    DB::table('competition_interested_users')
    -> where('user_id',$user_id)
    ->update(['is_status'=>0]);
  }

  //update vote amount for first place
  public static function update_amount_edit($vote_amount,$user_id)
  {
    DB::table('competition_interested_users')
    -> where('user_id',$user_id)
    ->update(['vote_amount'=>$vote_amount]);
  }

  //update vote amount for second place
  public static function update_second_place_amount_edit($vote_amount,$user_id)
  {
    DB::table('competition_interested_users')
    -> where('user_id',$user_id)
    ->update(['vote_amount'=>$vote_amount]);
  }

  //update vote amount for third place
  public static function update_third_place_amount_edit($vote_amount,$user_id)
  {
    DB::table('competition_interested_users')
    -> where('user_id',$user_id)
    ->update(['vote_amount'=>$vote_amount]);
  }

  //select vote amount
  public static function select_vote_amount($user_id)
  {
    $get_amount = DB::table('competition_interested_users')
                  ->select('vote_amount')
                  ->where('user_id',$user_id)
                  ->first();
    return $get_amount;
  }

  //update title
  public static function update_title($edit_title,$user_id)
  {
    DB::table('competition_expiry_date')
    ->where('user_id',$user_id)
    ->update(['competition_title'=>$edit_title]);
  }

  //fetch the title
  public static function get_title()
  {
    $get_title  = DB::table('competition_expiry_date')
                  ->select('competition_title')
                  ->get();
    return $get_title[0]->competition_title;
  }

  //get comment user data
  public static function comment_user_data($user_id)
  {
    $user_data  = DB::table('competition_interested_users')
                  ->select('users.*','competition_interested_users.*')
                  ->join('users','users.id','=','competition_interested_users.user_id')
                  ->where('competition_interested_users.user_id', '=', $user_id)
                  ->get();
    return $user_data ;
  }

  //add comment
  public static function confirm_comment($comment,$competition_user_id,$competition_id,$user_id)
  {
    DB::table('profile_comments')
    ->insert(['competition_id'=>$competition_id,'sender_id'=>$user_id,'comment'=>$comment]);
    
    $get_comment  = DB::table('profile_comments')
                    ->select('profile_comments.*','users.img','users.username')
                    ->join('users','users.id','=','profile_comments.sender_id') 
                    ->where('profile_comments.competition_id',$competition_id)
                    ->where('is_deleted',0)
                    ->orderBy('created_at','desc')
                    ->get();
      foreach ($get_comment as $key => $comment_data) 
      {
        $comment_count = DB::table('profile_comments')
                        ->select('comment')
                        ->where('competition_id',$comment_data->competition_id)
                        ->get();
        $get_comment[$key]->total_comment = count($comment_count);
      }
      return $get_comment;
  }

  //fetch comment
  public static function get_comments($user_id)
  {
    $get_comments  = DB::table('profile_comments')
                    ->select('profile_comments.*','users.username','users.img' )
                    ->join('users','users.id','=','profile_comments.sender_id')
                    ->leftjoin('competition_interested_users','competition_interested_users.competition_id','=','profile_comments.competition_id')
                    ->where('competition_interested_users.user_id',$user_id)
                    ->where('is_deleted',0)
                    ->orderBy('created_at','desc')
                    ->get();
    return $get_comments;
  }

  //delete comment
  public static function soft_delete_comment($comment_id)
  {
    DB::table('profile_comments')
    ->where('id',$comment_id)
    ->update(['is_deleted'=>1]);
  }

  //delete all competition users
  public static function delete_all_competition()
  {
    DB::table('competition_interested_users')->delete();
  }

  //delete all votes
  public static function delete_all_competition_votes()
  {
    DB::table('competiton_vote')->delete();
  }
  
  //delete all comments
  public static function delete_all_competition_comment()
  {
    DB::table('profile_comments')->delete();
  }

  //get image for popup
  public static function expand_image($user_id)
  {
    $expand_image = DB::table('competition_interested_users')
                    ->select('user_profile','users.username')
                    ->join('users','users.id','=','competition_interested_users.user_id')
                    ->where('user_id',$user_id)
                    ->get(); 
    return $expand_image;   
  }
}