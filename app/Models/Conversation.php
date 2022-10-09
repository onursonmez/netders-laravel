<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use HasFactory;

    public function other() {
        return $this->hasOne(Conversation_participant::class, 'conversation_id', 'id')->where('user_id', '!=', Auth::user()->id)->first();
    }

    public function last_message() {
        return $this->hasOne(Conversation_message::class, 'conversation_id', 'id')->with('user')->latest()->first();
    }

    public function me() {
        return $this->hasOne(Conversation_participant::class, 'conversation_id', 'id')->where('user_id', Auth::user()->id)->first();
    }

    public function messages() {
        return $this->hasMany(Conversation_message::class, 'conversation_id', 'id')->doesntHave('deleted_messages')->with('user')->limit(500);
    }    
    
    public function deleted_conversations() {
        return $this->hasMany(Conversation_deleted_conversation::class, 'conversation_id', 'id')->where('user_id', Auth::user()->id);
    }         
    
    public function blockeds() {
        return $this->hasMany(Conversation_blocked::class, 'conversation_id', 'id')->where('user_id', Auth::user()->id);
    }             
    
    public function participants() {
        return $this->hasMany(Conversation_participant::class)->with('user');
    }                 
}
