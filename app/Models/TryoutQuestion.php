<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutQuestion extends Model
{
    protected $fillable = [
        'tryout_id', 'order_number', 'category',
        'question_text', 'question_image',
        'option_a', 'option_a_image', 'score_a',
        'option_b', 'option_b_image', 'score_b',
        'option_c', 'option_c_image', 'score_c',
        'option_d', 'option_d_image', 'score_d',
        'option_e', 'option_e_image', 'score_e',
        'correct_answer', 'explanation'
    ];

    public function tryout()
    {
        return $this->belongsTo(Tryout::class);
    }
    
    public function getScoreForOption($option)
    {
        $scoreColumn = 'score_' . $option;
        return $this->$scoreColumn ?? 0;
    }
    
    public function getOptionImage($option)
    {
        $imageColumn = 'option_' . $option . '_image';
        return $this->$imageColumn;
    }
}