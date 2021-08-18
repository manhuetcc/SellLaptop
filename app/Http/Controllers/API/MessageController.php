<?php

namespace App\Http\Controllers\API;

use App\Events\MessagePosted;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $role_id = User::where('id', $id)->first();
        if ($role_id->role_id == 1) {
            $messages = Message::where('channel', $id)->get();
            return $messages;
        }
        $messages =  Message::all();
        return $messages;
    }

    public function getMessage($channel)
    {
        $message = Message::where('channel', $channel)->get();
        return $message;
    }
    //luu tin nhan
    public function store(Request $request)
    {
        $message = new Message();
        $message->content = $request->content;
        $message->channel = $request->channel;
        $message->sender = Auth::id();
        $message->save();
        broadcast(new MessagePosted($message))->toOthers();
        //echo $message->channel;
        return response()->json(['message' => $message]);
    }

    public function requestBot(Request $request)
    {
        $message = new Message();
        $message->content = $request->content;
        $message->channel = $request->channel;
        $message->sender = 1;
        $message->save();
        broadcast(new MessagePosted($message))->toOthers();
        return response()->json(['message' => $message]);
    }
    //lay danh sach nguoi gui
    public function listMessage()
    {
        $listMessage = DB::table('messages')
            ->groupBy('channel')
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json(
            [
                $listMessage,
            ]
        );
    }

    //lay danh sach tin nhan mau
    public function msgResponse()
    {
        $listMessage = DB::table('chatbots')->select('msg', 'response as respond')
            ->get();
        return  $listMessage;
    }
}
