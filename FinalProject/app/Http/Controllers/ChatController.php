<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function adminChatPage(){
        $userID = Auth::user()['id'];

        // $convas = DB::table('chats')
        //     ->select(DB::raw('
        //         CASE
        //             WHEN sender_id = ? THEN receiver_id
        //             ELSE sender_id
        //         END AS other_id,
        //         MAX(created_at) AS last_messaged_at,
        //         (SELECT message
        //          FROM chats AS sub
        //          WHERE (sub.sender_id = ? AND sub.receiver_id = chats.receiver_id) OR
        //                (sub.sender_id = chats.receiver_id AND sub.receiver_id = ?)
        //          ORDER BY created_at DESC
        //          LIMIT 1) AS last_message
        //     ', [$userID, $userID, $userID]))
        //     ->where(function ($query) use ($userID) {
        //         $query->where('sender_id', $userID)
        //             ->orWhere('receiver_id', $userID);
        //     })
        //     ->groupBy('other_id')
        //     ->orderBy('last_messaged_at', 'desc')
        //     ->get();


        $convas = DB::table('chats')
        ->select(DB::raw('
            CASE
                WHEN sender_id = '.$userID.' THEN receiver_id
                ELSE sender_id
            END AS other_id,
            MAX(created_at) AS last_messaged_at,
            (SELECT id
             FROM chats AS sub
             WHERE (sub.sender_id = '.$userID.' AND sub.receiver_id = other_id) OR
                   (sub.sender_id = other_id AND sub.receiver_id = '.$userID.')
             ORDER BY created_at DESC
             LIMIT 1)AS last_message_id'
            //  ,[$userID, $userID, $userID]
        ))
        ->where(function ($query) use ($userID) {
            $query->where('sender_id', $userID)
                ->orWhere('receiver_id', $userID);
        })
        ->groupBy('other_id')
        ->orderBy('last_messaged_at', 'desc')
        // ->setBindings(['user_id' => $userID], 'select') // Set the bindings for the named parameter ":user_id"
        ->get()->toArray();

        for ($i=0; $i < count($convas); $i++) {
            $otheruser = User::where('id','=',$convas[$i]->other_id)->first();
            $convas[$i]->other_name = $otheruser->name;
            $convas[$i]->other_profile = $otheruser->profile;
            $convas[$i]->other_gender = $otheruser->gender;

            $last_message = Chat::where('id','=',$convas[$i]->last_message_id)->first();
            $convas[$i]->last_msg_message = $last_message['message'];
            $convas[$i]->last_msg_sender = $last_message['sender_id'];
        }
        // if($last_message->sender_id == Auth::user()['id']){

        // }else{

        // }
        // dd($convas);
        return view('admin.chat.chatlist',compact('convas'));
    }

    public function adminChat($otheruser){
        // dd($otheruser);
        $otheruser = User::where('id',$otheruser)->first();
        return view('admin.chat.chat',compact('otheruser'));
    }

    public function chatList($other_id){

        $chats =  Chat::where(function ($query) use ($other_id) {
                            $query->where('sender_id', $other_id)
                                ->where('receiver_id', Auth::user()['id']);
                        })->orWhere(function ($query) use ($other_id) {
                            $query->where('receiver_id', $other_id)
                                ->where('sender_id', Auth::user()['id']);
                        })->get()->toArray();
        logger($chats);
        for ($i=0; $i < count($chats); $i++) {
            if($chats[$i]['deleted']  == 1){
                $chats[$i]['message'] = null;
            }
        }
        // dd($chats);
        return response()->json($chats);
    }

    public function sendMessage(Request $req,$receiverID){
        // dd('arrive');
        Chat::create([
                      'sender_id' => Auth::user()['id'],
                      'receiver_id' => $receiverID,
                      'message' => $req->message
                    ]);
        return 'success';
    }
    public function seenMessage(){
        Chat::where('receiver_id','=',Auth::user()['id'])->update(['seen' => 1]);
        return 'seen';
    }
    public function deleteMessage($message_id){
        Chat::where('id','=',$message_id)->update(['deleted' => true]);
    }

    public function chatunseen(){
        $chatunseen = Chat::where('receiver_id',Auth::user()['id'])
                            ->where('seen','=',0)
                            ->count();

        return response()->json(['chatunseen' => $chatunseen]);
    }
}
