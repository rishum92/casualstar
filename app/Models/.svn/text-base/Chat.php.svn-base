<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App;
use Auth;
use MongoDB;
use DB;

class Chat extends Eloquent {

	protected $connection = 'mongodb';
	
	public static function getChats() {
		$chats = DB::connection('mongodb')->collection('chats')->get();
		return $chats;
	}

	public static function startChat($userId) {
		$chats = DB::connection('mongodb')->collection('chats')->get();
		return $chats;
	}

	public static function deleteMessage($data) { 
		$chat = DB::connection('mongodb')->collection('chats')->find($data['chatId']);
		foreach($chat['messages'] as $key => $message) {
			if($message['_id'] == $data['messageId'] && Auth::user()->id == $data['userId']) {
				$chat['messages'][$key]['deleted'][] = Auth::user()->id;
				DB::connection('mongodb')->collection('chats')->where('_id', $data['chatId'])->update(['messages' => $chat['messages']]);
				// DB::connection('mongodb')->collection('chats')->where('_id', $data['chatId'])->pull('messages', $message);
			}
		}
	}

	public static function deleteChat($data) { 
		$chat = DB::connection('mongodb')->collection('chats')->find($data['_id']);
		foreach($chat['ids'] as $id) {
			if(Auth::user()->id == $id) {
				DB::connection('mongodb')->collection('chats')->where('_id', $data['_id'])->push('deleted', Auth::user()->id);
			}
		}
	}
}