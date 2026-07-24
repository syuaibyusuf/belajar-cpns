<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageQuestion extends Model
{
    protected $table = 'package_questions';
    
    protected $fillable = [
        'package_id', 'order_number',
        'question_text', 'question_image',
        'option_a', 'option_a_image',
        'option_b', 'option_b_image',
        'option_c', 'option_c_image',
        'option_d', 'option_d_image',
        'option_e', 'option_e_image',
        'correct_answer',
        'score_a', 'score_b', 'score_c', 'score_d', 'score_e',
        'explanation'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    
    // Helper untuk mendapatkan nilai opsi (TKP)
    public function getScoreForOption($option)
    {
        $scoreColumn = 'score_' . $option;
        return $this->$scoreColumn ?? 0;
    }
    
    // Helper untuk mendapatkan gambar opsi
    public function getOptionImage($option)
    {
        $imageColumn = 'option_' . $option . '_image';
        return $this->$imageColumn;
    }
}