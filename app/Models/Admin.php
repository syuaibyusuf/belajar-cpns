<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isEditor()
    {
        return $this->role === 'editor';
    }
}