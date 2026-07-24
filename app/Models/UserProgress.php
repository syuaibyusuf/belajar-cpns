<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progress';
    
    protected $fillable = [
        'session_id', 'category', 'score', 'total_questions', 'answers'
    ];

    protected $casts = [
        'answers' => 'array'
    ];
}