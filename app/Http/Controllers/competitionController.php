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
                        ->insert(['user_id'=>$user_id, 'username'=>$user->username, 'user_profile'=>$profilePhotoFile]);
                        
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
        $removecompetition= competition_user::removecompetition($competitionid);
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
        $confirm_vote = $request->confirm_vote;
        $competitionid = $request->competitionid;
        $competition_userid = $request->competition_userid;
        $voter_id = Auth::user()->id;
        $voter= competition_user::confirm_vote($confirm_vote, $voter_id, $competition_userid, $competitionid);
        $getdata = competition_user::getdata();
        $voter_count = competition_user::vote_count($voter_id);
        //echo "<pre>";print_r($voter_count);die;
        return view('competition_users',['competitionuser' =>$getdata,'voter_count'=>$voter_count]);
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
         $termscondition  = $request->input('terms_condition');
         $terms_condition = competition_user::termscondition($user_id,$termscondition);
         return redirect('competitions');
     }
     public function storecomment(Request $request)
     {
        echo "success";
     }
      
    public function destroy($id){
        $execute = Photo::remove($id);
        $success = Lang::get('messages.photoRemoved');
        $error   = Lang::get('messages.errorMsg');
        
        return $this->response($execute, $success ,$error);
                
        }
    public function amount_edit(Request $request)
    {
        echo $amount     = $request->amount_edit;
        echo $user_id    = $request->hidden_user_id;die;
        $updatedate = competition_user::update_vote_amount($amount);

    }

    
}

