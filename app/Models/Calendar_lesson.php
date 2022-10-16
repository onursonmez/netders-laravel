<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar_lesson extends Model
{
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(\App\Models\User::class, 'teacher_id', 'id');
    }        

    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id', 'id');
    }            
}
