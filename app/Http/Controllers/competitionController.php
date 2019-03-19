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
                        ->insert(['user_id'=>$user_id, 'username'=>$user->username,       'user_profile'=>$profilePhotoFile]);
                        
                        print_r($insertdata);die;
              
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
    
     public function delete(Request $request)
     {
        echo $id = $request->id;die;
     }

     public function editd(Request $request)
     {
       $date       = $request->date;
       $user_id    = Auth::user()->id;
       $updatedate= competition_user::updateexpirydate($date,$user_id);

      return view('competitions',['updatedate'=>$updatedate]);
     }
     public function termsstore(Request $request)
     {
         $user_id         = Auth::user()->id;
         $termscondition  = $request->input('terms_condition');
         $terms_condition = competition_user::termscondition($user_id,$termscondition);
          return redirect('competitions');
     }
      
    public function destroy($id){
        $execute = Photo::remove($id);
        $success = Lang::get('messages.photoRemoved');
        $error = Lang::get('messages.errorMsg');
        
        return $this->response($execute, $success ,$error);
                
        }


    public function index() {
        $page = Input::get('page');
        $perPage = Input::get('perPage');
        $photos = Photo::whereHas('user', function($q) {$q->where('status', 1);})->with('user')->where("created_at",">",Carbon::now()->subDay(30))->whereNull('deleted_at')->orderBy('created_at', 'DESC')->where('hidden', 0)->limit($perPage)->skip($page * $perPage - $perPage)->get();
        $count = Photo::whereHas('user', function($q) {$q->where('status', 1);})->where("created_at",">",Carbon::now()->subDay(30))->whereNull('deleted_at')->orderBy('created_at', 'DESC')->where('hidden', 0)->count();

        $data = new \stdClass;
        $data->photos = $photos;
        $data->count = $count;

        return $this->response($data, '', '');
    }

    public function update($id) {
        $execute = Photo::updateField($id, Input::all());
        $success = Lang::get('messages.photoRemoved');
        $error = Lang::get('messages.errorMsg');
        
        return $this->response($execute, $success ,$error);
    }
    public function search()
    {
        return "success";
    }
}

