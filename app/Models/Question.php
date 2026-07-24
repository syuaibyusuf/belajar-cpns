<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'category', 'question_text', 'question_image',
        'option_a', 'image_a', 'score_a',
        'option_b', 'image_b', 'score_b',
        'option_c', 'image_c', 'score_c',
        'option_d', 'image_d', 'score_d',
        'option_e', 'image_e', 'score_e',
        'correct_answer', 'explanation', 'difficulty', 'points', 'created_by'
    ];

    protected $casts = [
        'question_image' => 'string',
        'image_a' => 'string',
        'image_b' => 'string',
        'image_c' => 'string',
        'image_d' => 'string',
        'image_e' => 'string',
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public static function getCategories()
    {
        return [
            'twk' => ['name' => 'Tes Wawasan Kebangsaan', 'icon' => '🇮🇩', 'color' => 'red'],
            'tiu' => ['name' => 'Tes Intelegensi Umum', 'icon' => '🧠', 'color' => 'blue'],
            'tkp' => ['name' => 'Tes Karakteristik Pribadi', 'icon' => '💼', 'color' => 'green'],
        ];
    }
    
    // Helper untuk mendapatkan nilai opsi berdasarkan jawaban (TKP)
    public function getScoreForOption($option)
    {
        $scoreColumn = 'score_' . $option;
        return $this->$scoreColumn ?? 0;
    }
    
    // Helper untuk mendapatkan gambar opsi
    public function getOptionImage($option)
    {
        $imageColumn = 'image_' . $option;
        return $this->$imageColumn;
    }
}