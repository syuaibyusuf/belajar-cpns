<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->integer('order_number')->default(0);
            
            // Soal
            $table->text('question_text');
            $table->longText('question_image')->nullable();
            
            // Opsi A
            $table->string('option_a');
            $table->longText('option_a_image')->nullable();
            
            // Opsi B
            $table->string('option_b');
            $table->longText('option_b_image')->nullable();
            
            // Opsi C
            $table->string('option_c');
            $table->longText('option_c_image')->nullable();
            
            // Opsi D
            $table->string('option_d');
            $table->longText('option_d_image')->nullable();
            
            // Opsi E
            $table->string('option_e');
            $table->longText('option_e_image')->nullable();
            
            // Untuk TWK/TIU
            $table->enum('correct_answer', ['a', 'b', 'c', 'd', 'e'])->nullable();
            
            // Untuk TKP (nilai per opsi 1-5)
            $table->integer('score_a')->default(0);
            $table->integer('score_b')->default(0);
            $table->integer('score_c')->default(0);
            $table->integer('score_d')->default(0);
            $table->integer('score_e')->default(0);
            
            // Pembahasan
            $table->text('explanation')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_questions');
    }
};