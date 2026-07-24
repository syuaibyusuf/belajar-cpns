<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickPackageQuestion extends Model
{
    protected $table = 'quick_package_questions';
    
    protected $fillable = [
        'quick_package_id', 'question_id', 'order_number'
    ];

    public function quickPackage()
    {
        return $this->belongsTo(QuickPackage::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}