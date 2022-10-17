<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat(){
        return view('welcome');
    }
    public function __sendMessage(Request $request){
        $data = $request->all();
        $message = $data['message'];
        event(new ChatEvent($request->message, 1));
    }
}
