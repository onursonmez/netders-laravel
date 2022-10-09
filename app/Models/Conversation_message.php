<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Conversation_message extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }        

    public function deleted_messages() {
        return $this->hasMany(Conversation_deleted_message::class, 'message_id', 'id')->where('user_id', Auth::user()->id);
    }           
}
