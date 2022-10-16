<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Conversation as Conversation;
use App\Models\Conversation_blocked as BlockedConversations;
use App\Models\Conversation_deleted_conversation as DeletedConversations;
use App\Models\Conversation_deleted_message as DeletedMessages;
use App\Models\Conversation_message_attachment as Attachments;
use App\Models\Conversation_message as Messages;
use App\Models\Conversation_participant as Participants;
use App\Models\Conversation_reported as Reporteds;
use Lang;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /*
     Chat ana ekrani
    */
    public function index()
    {
        return view('chat/index');
    }

    /*
     Kisileri yukle
    */
    public function persons(Request $request)
    {
        $search = $request->get('search');
        
        if($request->get('search'))
        {
            $conversations = Auth::user()->conversations()->doesntHave('deleted_conversations')->doesntHave('blockeds')->whereHas('participants.user', function($query) use ($search) {
                $query->where('first_name', 'ilike', '%'.$search.'%')->where('user_id', '!=', Auth::user()->id);
            })->get();            
        }
        else
        {
            $conversations = Auth::user()->conversations()->doesntHave('deleted_conversations')->doesntHave('blockeds')->get(); 
        }

        if($conversations->isNotEmpty())
        {
            $returnHTML = view('chat.load_persons')->with('conversations', $conversations)->render();
            return response()->json(['success' => true, 'count' => sizeof($conversations), 'html'=> $returnHTML]);          
        }

        return abort(404);
    }    

    /*
     Sohbet detay sayfasi
    */
    public function detail(Request $request, $id)
    {
        $conversation = Auth::user()->conversations()->find($id);

        if(!empty($conversation))
        {
            $participant = Participants::where('conversation_id', $conversation->id)->where('user_id', Auth::user()->id)->first();
            $participant->unread = NULL;
            $participant->save();
        
            $timezone = new \Carbon\CarbonTimeZone('Europe/Istanbul');
            $returnHeaderHTML = view('chat.load_header')->with('conversation', $conversation)->render();
            $returnBodyHTML = view('chat.load_message')->with('conversation', $conversation)->with('timezone', $timezone)->render();
            return response()->json(['success' => true, 'body'=> $returnBodyHTML, 'header' => $returnHeaderHTML]);          
        }

        return abort(404);
    }

    /*
     Sohbet kaydet
    */
    public function send(Request $request)
    {
        //Profil detayindan veya harici olarak gelirse
        if(empty($request->get('conversation_id')) && Auth::check())
        {
            $request->validate([
                'user_id' => 'required',
                'message' => 'required',
            ]);      
            
            $check = Participants::whereIn('user_id', [Auth::user()->id, $request->get('user_id')])->groupBy('conversation_id')->havingRaw('count(user_id) = ?', [2])->get('conversation_id')->first();
            if(empty($check))
            {
                $conversation = new Conversation;
                $conversation->user_id = Auth::user()->id;
                $conversation->save();
                $conversation_id = $conversation->id;
    
                if(!empty($conversation_id))
                {
                    $participants = new Participants;
                    $participants->conversation_id = $conversation_id;
                    $participants->user_id = Auth::user()->id;
                    $participants->save(); 
                    
                    $participants = new Participants;
                    $participants->conversation_id = $conversation_id;
                    $participants->user_id = $request->get('user_id');
                    $participants->save();                      
                }
            }
            else
            {
                $conversation_id = $check->conversation_id;
            }

            $message = new Messages;
            $message->conversation_id = $conversation_id;
            $message->user_id = Auth::user()->id;
            $message->message_type = 1;
            $message->message = $request->get('message');
            $message = $message->save();   

            $participants = Participants::where('conversation_id', $conversation_id)->where('user_id', '!=', Auth::user()->id)->get();
                
            if(!empty($participants))
            {
                foreach($participants as $participant)
                {
                    $participant->unread = $participant->unread > 0 ? $participant->unread+1 : 1;
                    $participant->save();
                }
            }

            $data = [
                'conversation_id' => $request->get('conversation_id'), 
                'text' => $request->get('message'),
                'avatar' => asset(Auth::user()->photo->url ?? (Auth::user()->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')),
                'name' => Auth::user()->first_name . ' ' . Auth::user()->last_name
            ];
            broadcast(new \App\Events\NewMessage($data))->toOthers();            
            
            return $request->wantsJson()
                        ? response()->json(['success' => [Lang::get('chat.send_success')]])
                        : redirect()->back()->with(['messages' => [Lang::get('chat.send_success')]]);  
        }
        //Chat icinden gelirse
        elseif($request->get('conversation_id'))
        {
            $request->validate([
                'message' => 'required',
            ]);       

            $conversation = Conversation::find($request->get('conversation_id'));

            if(!empty($conversation))
            {
                $conversation->touch();

                $message = new Messages;
                $message->conversation_id = $request->get('conversation_id');
                $message->user_id = Auth::user()->id;
                $message->message_type = 1;
                $message->message = $request->get('message');
                $message = $message->save();   
                
                DeletedConversations::where('conversation_id', $request->get('conversation_id'))->delete();
                

                $participants = Participants::where('conversation_id', $request->get('conversation_id'))->where('user_id', '!=', Auth::user()->id)->get();
                
                if(!empty($participants))
                {
                    foreach($participants as $participant)
                    {
                        $participant->unread = $participant->unread > 0 ? $participant->unread+1 : 1;
                        $participant->save();
                    }
                }

                $data = [
                    'conversation_id' => $request->get('conversation_id'), 
                    'text' => $request->get('message'),
                    'avatar' => asset(Auth::user()->photo->url ?? (Auth::user()->detail->gender == 'M' ? 'img/icon-male.png' : 'img/icon-female.png')),
                    'name' => Auth::user()->first_name . ' ' . Auth::user()->last_name
                ];
                broadcast(new \App\Events\NewMessage($data))->toOthers();
                
                return response()->json(['success' => true]); 
            }
        }
        else
        {
            return $request->wantsJson()
                        ? response()->json(['errors' => [Lang::get('chat.send_failed')]], 422)
                        : redirect()->back()->withErrors(['errors' => [Lang::get('chat.send_failed')]]);        
        }

        //$returnHTML = view('chat.load_message')->with('messages', $messages)->render();
        //return response()->json(['success' => true, 'html'=> $returnHTML]);          
    }
    
    public function delete_conversation(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required',
        ]);       

        $conversation = Auth::user()->conversations()->find($request->get('conversation_id'));

        if(!empty($conversation))
        {
            $deletedConversation = new DeletedConversations;
            $deletedConversation->conversation_id = $request->get('conversation_id');
            $deletedConversation->user_id = Auth::user()->id;
            $deletedConversation->save();              
            
            foreach($conversation->messages as $message)
            {
                $deletedMessage = new DeletedMessages;
                $deletedMessage->conversation_id = $request->get('conversation_id');
                $deletedMessage->message_id = $message->id;
                $deletedMessage->user_id = Auth::user()->id;
                $deletedMessage->save();    
            }
            
            return response()->json(['success' => true]); 
        }

        $returnHTML = view('chat.load_message')->with('messages', $messages)->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);          
    }    

    public function block_conversation(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required',
        ]);       

        $conversation = Auth::user()->conversations()->find($request->get('conversation_id'));

        if(!empty($conversation))
        {
            $deletedConversation = new BlockedConversations;
            $deletedConversation->conversation_id = $request->get('conversation_id');
            $deletedConversation->user_id = Auth::user()->id;
            $deletedConversation->save();              
            
            return response()->json(['success' => true]); 
        }

        $returnHTML = view('chat.load_message')->with('messages', $messages)->render();
        return response()->json(['success' => true, 'html'=> $returnHTML]);          
    }  
}
