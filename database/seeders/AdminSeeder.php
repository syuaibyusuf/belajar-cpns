<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        ]);
        
        Admin::create([
            'name' => 'Editor',
            'email' => 'editor@admin.com',
            'password' => Hash::make('password'),
            'role' => 'editor'
        ]);
    }
}