<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\UserProvider;
use App\Models\serviceProvider;
use Session;
use Cookie;
use Auth;
use Twitter;
use File;
use Laravel\Socialite\Contracts\Factory as Socialite;  

class TwitterController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	 public $reg_twit = 1;
	 public $post_twit = 0;
	 public $token = null;
	 public $secret = null;
	 
	public function __construct(){
	    
		// dd(session::get('oauth.temp'));die;
		$twit_user = UserProvider::where('user_id',Auth::user()->id)->first();
		$get_provider = serviceProvider::where('user_id',Auth::user()->id)->first();
		if($get_provider || $twit_user){
			/* $this->token = Session::get('oauth_token');
			$this->secret = Session::get('oauth_token_secret'); */
			$this->reg_twit = 0;
			$this->post_twit = 1;
		}
	}
	
    public function twitterUserTimeLine()
    {
        try{
            if(Auth::user()->gender == 'male'){
    	        return redirect()->route('dashboard')->with('messageType', 'danger')->with('message', 'Invalid Authentication.');
    	    }
			else if(Auth::user()->social == 0){
				$twit_user = serviceProvider::where('user_id',Auth::user()->id)->first();
			}else if(Auth::user()->social == 1){
				$twit_user = UserProvider::where('user_id',Auth::user()->id)->first();
			}else{
				return redirect()->route('dashboard')->with('messageType', 'danger')->with('message', 'Invalid Authentication.');
			}
    		if($twit_user){
				/* echo "consumer_key ".getenv('TWITTER_ID');
				echo "<br/>consumer_secret ".getenv('TWITTER_SECRET');
				echo "<br/>access_token ".$twit_user->access_token;
				echo "<br/>access_token_secret ".$twit_user->access_token_secret;
    			dd($twit_user); */
    			// Access Token & Secret Token Used
    			Twitter::reconfigure([
    				'consumer_key'               => getenv('TWITTER_ID'),
    				'consumer_secret'            => getenv('TWITTER_SECRET'),
    				'token'						 => $twit_user->access_token,
    				'secret'					 => $twit_user->access_token_secret,
    			]);
				// dd(Twitter::logs());exit;
    			$data = Twitter::getUserTimeline(['count' => 20, 'format' => 'array']);
				// dd($data);
				$data_session = Session::all();
    			return view('twitter')->with('data', $data)->with('reg_twit', $this->reg_twit)->with('post_twit', $this->post_twit)->with('twit_token',$data_session);
    		}
        }
		catch(\Exception $e){
			/* $data_session = Session::all();
			return view('twitter')->with('reg_twit', 1)->with('post_twit', 0)->with('twit_token',$data_session); */
            return redirect()->route('dashboard')->with('messageType', 'danger')->with('message', $e->getMessage());
        }
		$data_session = Session::all();
		return view('twitter')->with('reg_twit', $this->reg_twit)->with('post_twit', $this->post_twit)->with('twit_token',$data_session);
		// return redirect()->route('dashboard')->with('messageType', 'info')->with('message', 'Invalid URL Request');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function tweet(Request $request)
    {
        try{
        	$this->validate($request, [
            		'tweet' => 'required|string|max:140'
            	]);
    
        	$newTwitte = ['status' => $request->tweet];
			if(Auth::user()->social == 0){
				$twit_user = serviceProvider::where('user_id',$request->input('uid'))->first();
			}else if(Auth::user()->social == 1){
				$twit_user = UserProvider::where('user_id',$request->input('uid'))->first();
			}else{
				return redirect()->route('dashboard')->with('messageType', 'danger')->with('message', 'Invalid Authentication.');
			}
    		// $twit_user = UserProvider::where('user_id',$request->input('uid'))->first();
    		// Access Token & Secret Token Used
    		Twitter::reconfigure([
    			'consumer_key'               => getenv('TWITTER_ID'),
    			'consumer_secret'            => getenv('TWITTER_SECRET'),
    			'token'						 => $twit_user->access_token,
    			'secret'					 => $twit_user->access_token_secret,
    		]);
        	if($request->hasFile('images')){
    			foreach ($request->images as $key => $value) {
    				$uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);
    				if(!empty($uploaded_media)){
    					$newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
    				}
    			}
        	}
    		
    		// $newTwitte = ['status' => "I have just received a new subscription to my Private Gallery at www.casualstar.uk/users/username  #Findom #ExclusiveContent."];
    
        	$twitter = Twitter::postTweet($newTwitte);
    
        	return back()->with('messageType', 'success')->with('message', "Your Tweet was sent.");
        }catch(\Exception $e){
            return back()->with('messageType', 'danger')->with('message', "Error Posting Tweet.");
        }
    }
}