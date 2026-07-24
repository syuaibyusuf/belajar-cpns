<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickPackage extends Model
{
    protected $table = 'quick_packages';
    
    protected $fillable = [
        'name', 'category', 'description', 'total_questions', 'status', 'created_by'
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quick_package_questions', 'quick_package_id', 'question_id')
                    ->withPivot('order_number')
                    ->orderBy('quick_package_questions.order_number');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}