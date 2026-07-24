<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    
    protected $fillable = [
        'name', 'category', 'description', 'total_questions', 'status', 'created_by'
    ];

    public function questions()
    {
        return $this->hasMany(PackageQuestion::class, 'package_id')->orderBy('order_number');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    
    public function isComplete()
    {
        return $this->questions()->count() == $this->total_questions;
    }
    
    public function getCategories()
    {
        return [
            'twk' => ['name' => 'Tes Wawasan Kebangsaan', 'icon' => '🇮🇩', 'color' => 'red'],
            'tiu' => ['name' => 'Tes Intelegensi Umum', 'icon' => '🧠', 'color' => 'blue'],
            'tkp' => ['name' => 'Tes Karakteristik Pribadi', 'icon' => '💼', 'color' => 'green'],
        ];
    }
}