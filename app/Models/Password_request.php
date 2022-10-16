<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_request extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
}
