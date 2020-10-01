<?php

namespace App\Http\Controllers\Chat;
use App\Events\NewMessage;
use App\User;
use App\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contacts(){
        //get all authentiocate user except login user
        $contacts = User::select('id','name','image')->whereHas('received_message')->orWhereHas('sent_message')->where('id','<>',auth()->id())->get();
        $unreadIds = Message::select(\DB::raw('`from_id` as sender_id, count(`from_id`) as messages_count'))
                ->where('to_id',auth()->id())
                ->where('seen',false)
                ->groupBy('from_id')
                ->get();
        $contacts = $contacts->map(function($contact) use($unreadIds){
            $contactUnread = $unreadIds->where('sender_id',$contact->id)->first();
            $contact->unread = $contactUnread?$contactUnread->messages_count : 0;
            return $contact;
        });
        return response()->json($contacts,200);
    }

    public function getMessagesFor($id){
        $message = Message::where('from_id',$id)->where('to_id',auth()->id())->update(['seen'=>true]);
        $message = Message::where(function($q) use ($id){
            $q->where('from_id',auth()->id());
            $q->where('to_id',$id);
        })->orWhere(function($q) use ($id){
            $q->where('from_id',$id);
            $q->where('to_id',auth()->id());
        })->get();
        return response()->json($message,200);
    }

    public function send(Request $request){
        
        $message = Message::create([
            'from_id' => auth()->id(),
            'to_id' =>  $request->contact_id,
            'text' => $request->text,
        ]);
        
        //broadcast(new NewMessage($message));
        return response()->json($message,200);
    }

    public function total_unread_messages(){
        $message = Message::where('to_id',auth()->id())->where('seen',false)->count();
        return response()->json($message,200);
    }
}
