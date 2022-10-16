<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Conversation_participant extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }     

    public function blockeds() {
        return $this->hasMany(Conversation_blocked::class, 'user_id', 'user_id')->where('user_id', Auth::user()->id);
    }      
}
