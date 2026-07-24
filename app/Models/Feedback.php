<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    
    protected $fillable = [
        'name', 'email', 'message', 'status', 'admin_response'
    ];
    
    public function getStatusBadge()
    {
        $badges = [
            'unread' => 'bg-yellow-100 text-yellow-600',
            'read' => 'bg-blue-100 text-blue-600',
            'responded' => 'bg-green-100 text-green-600'
        ];
        
        $labels = [
            'unread' => 'Belum Dibaca',
            'read' => 'Sudah Dibaca',
            'responded' => 'Sudah Direspon'
        ];
        
        return [
            'class' => $badges[$this->status],
            'label' => $labels[$this->status]
        ];
    }
}