<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use Image;
use Auth;
use Lang;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Photo;
use App\Models\PrivatePhoto;
use App\competition_user;
use DB;


class competitionController extends Controller
{
    public function add(Request $request) 
    {
        $data = Input::all();
        $caption = $data['title'];
        //echo "<pre>";print_r($title);die;
        $user = User::find(Auth::user()->id);
        $user_id = $user->id;
        $profilePhoto = $data['file'];
        $x = $data['crop']['x'];
        $y = $data['crop']['y'];
        $width = $data['crop']['width'];
        $height = $data['crop']['height'];
        $rotate = $data['crop']['rotate'];
        if(array_key_exists('file', $data)) {
        if (!file_exists('img/competition_user/' . $user->username)) {
            mkdir('img/competition_user/' . $user->username, 0777, true);
        }

        if (!file_exists('img/competition_user/' . $user->username . '/previews')) {
            mkdir('img/competition_user/' . $user->username . '/previews', 0777, true);
        }
        
        $ext = explode('/', $profilePhoto->getMimeType());

        if($ext[0] == 'image') {
            $imageInfo = getimagesize($profilePhoto);
            if($ext[1] == 'jpeg' || $ext[1] == 'png' || $ext[1] == 'gif') {
                if($ext[1] == 'jpeg') {
                    $ext = '.jpg';
                } else {
                    $ext = '.' . $ext[1];
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

        $profilePhotoFile = uniqid() . $ext;
        $profilePhoto->move('img/competition_user/' . $user->username, $profilePhotoFile);

        $profilePhotoPreview = Image::make('img/competition_user/' . $user->username . '/' . $profilePhotoFile);
        $profilePhotoPreview->rotate(-$rotate);
        $profilePhotoPreview->crop((int) $width, (int) $height, (int) $x, (int) $y);
        $profilePhotoPreview->resize(178,178, function ($constraint) {
            $constraint->aspectRatio();
        });
        $profilePhotoPreview->save('img/competition_user/' . $user->username . '/previews/' . $profilePhotoFile);
        
        $profilePhotoImage = Image::make('img/competition_user/' . $user->username . '/' . $profilePhotoFile);
        $profilePhotoImage->rotate(-$rotate);
        $profilePhotoImage->crop((int) $width, (int) $height, (int) $x, (int) $y);
        $profilePhotoImage->resize(900, 900, function ($constraint) {
            $constraint->aspectRatio();
        });
        $profilePhotoImage->save();

        $insertdata = DB::table('competition_interested_users')
                    ->insert(['user_id'=>$user_id, 'username'=>$user->username, 'user_profile'=>$profilePhotoFile,'caption'=>$caption]);
                    
        $success = Lang::get('messages.photoAdded');
        $error = Lang::get('messages.errorMsg');
        
        return $this->response($user, $success ,$error);
        } else {
        return false;
        }
       
    }
    public function displaydata()
    {
        $getdata = competition_user::getdata();
        return view('competitions');
    }
    
    public function competitiondelete(Request $request)
    {
        $competitionid = $request->id;
        $competitiondelete= competition_user::competitiondelete($competitionid);
        $votedelete     = competition_user::votedelete($competitionid);
        $commentdelete     = competition_user::commentdelete($competitionid);
        return redirect('competitions');
    }

    public function editd(Request $request)
    {
        $date       = $request->date;
        $user_id    = Auth::user()->id;
        $updatedate= competition_user::updateexpirydate($date,$user_id);

        return view('competitions',['updatedate'=>$updatedate]);
    }

    public function confirm_vote(Request $request)
    {
        $competitionid      = $request->competitionid;
        $competition_userid = $request->competition_userid;
        $confirm_vote       = $request->confirm_vote;
        $voter_id           = Auth::user()->id;
        $voter_id           = competition_user::confirm_vote($confirm_vote, $voter_id, $competition_userid, $competitionid);
        $getdata = competition_user::getdata();
        $voter_count = competition_user::vote_count($voter_id);
        $showdate= competition_user::showdate();
        $updatedate = $showdate[0]->ExpiryDate;
        $date_array = explode("-",$updatedate); // split the array
        $var_year = $date_array[0]; //day seqment
        $var_month = $date_array[1]; //month segment
        $var_day = $date_array[2]; //year segment
        $new_date_format = "$var_day/$var_month/$var_year";
        
        return view('competition_users',['competitionuser' =>$getdata,'voter_count'=>$voter_count,'showdate'=>$new_date_format]);
    }
     
    public function expand_image(Request $request)
    {
        $id = $request->id;
        $expand_image = DB::table('competition_interested_users')
                       ->select('user_profile','username')
                       ->where('user_id',$id)
                        ->get();
        return $expand_image;
    }

    public function termsstore(Request $request)
    {
        $user_id         = Auth::user()->id;
        $termscondition  = $request->textareaValue;
        $terms_condition = competition_user::termscondition($user_id,$termscondition);
        return redirect('competitions');
    }
    
    public function destroy($id)
    {
        $execute = Photo::remove($id);
        $success = Lang::get('messages.photoRemoved');
        $error   = Lang::get('messages.errorMsg');
        return $this->response($execute, $success ,$error);
    }
    public function amount_edit(Request $request)
    {
        $vote_amount            = $request->amount_edit;
        $user_id                = $request->hidden_user_id;
        $update_vote_amount     = competition_user::update_amount_edit($vote_amount,$user_id);
        return redirect('competitions');
    }
    
    public function edit_title(Request $request)
    {
        $edit_title         = $request->title;
        $user_id            = Auth::user()->id;
        $updateexpirydate   = competition_user::update_title($edit_title ,$user_id);
        return view('competitions');
    }
    public function comment_user_data(Request $request)
    {
        $user_id     = $request->id; 
        $user_data   = competition_user::comment_user_data($user_id);

        $get_comment = competition_user::getcomments($user_id);
        $data = array(
                    'user_data' => $user_data,
                    'get_comment' => $get_comment
                );
        return json_encode($data);
    }
    public function confirm_comment(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $date                   =   date('Y-m-d H:i:s');
        $comment                =   $request->comment;
        $competition_user_id    =   $request->competition_user_id;
        $competition_id         =   $request->competition_id;
        $user_id                =   Auth::user()->id;
        $user_comment           =   competition_user::confirm_comment($comment,$competition_user_id,$competition_id,$user_id,$date);
        return $user_comment;
    }
    public function delete_comment(Request $request)
    {
        $comment_id = $request->id;
        competition_user::deletecomment($comment_id);
        return redirect('competitions');
    }
}

