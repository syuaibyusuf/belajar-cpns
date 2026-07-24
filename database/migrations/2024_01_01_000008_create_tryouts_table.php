<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration')->default(100); // menit
            $table->integer('total_questions_twk')->default(30);
            $table->integer('total_questions_tiu')->default(35);
            $table->integer('total_questions_tkp')->default(45);
            $table->integer('total_questions')->default(110);
            $table->enum('status', ['draft', 'active'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryouts');
    }
};