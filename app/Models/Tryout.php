<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    protected $fillable = [
        'name', 'description', 'duration', 
        'total_questions_twk', 'total_questions_tiu', 'total_questions_tkp',
        'total_questions', 'status', 'created_by'
    ];

    public function questions()
    {
        return $this->hasMany(TryoutQuestion::class, 'tryout_id')->orderBy('order_number');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    
    public function isComplete()
    {
        return $this->questions()->count() == $this->total_questions;
    }
    
    public function getMaxScore()
    {
        $maxScore = 0;
        foreach ($this->questions as $question) {
            if ($question->category == 'tkp') {
                $maxScore += 5;
            } else {
                $maxScore += 5;
            }
        }
        return $maxScore;
    }
    
    public function getMaxScoreByCategory($category)
    {
        $maxScore = 0;
        foreach ($this->questions as $question) {
            if ($question->category == $category) {
                $maxScore += 5;
            }
        }
        return $maxScore;
    }
}