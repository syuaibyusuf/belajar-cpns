<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamPackage extends Model
{
    protected $fillable = [
        'name', 'category', 'description', 'total_questions', 'status', 'created_by'
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'package_questions', 'package_id', 'question_id')
                    ->withPivot('order_number')
                    ->orderBy('package_questions.order_number');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function getScoringSystem()
    {
        if ($this->category == 'tkp') {
            return 'Skala 1-5 (tidak ada nilai 0)';
        }
        return 'Benar = 5 poin, Salah = 0 poin';
    }
}
