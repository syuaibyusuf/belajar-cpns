<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['twk', 'tiu', 'tkp']);
            $table->longText('content');
            $table->integer('order_number')->default(0);
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->string('image')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};