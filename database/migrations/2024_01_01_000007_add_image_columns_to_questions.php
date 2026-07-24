<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Kolom untuk gambar soal (base64)
            $table->longText('question_image')->nullable()->after('question_text');
            
            // Kolom untuk gambar opsi jawaban (base64)
            $table->longText('image_a')->nullable()->after('option_a');
            $table->longText('image_b')->nullable()->after('option_b');
            $table->longText('image_c')->nullable()->after('option_c');
            $table->longText('image_d')->nullable()->after('option_d');
            $table->longText('image_e')->nullable()->after('option_e');
            
            // Kolom nilai untuk TKP (per opsi)
            $table->integer('score_a')->default(0)->after('image_e');
            $table->integer('score_b')->default(0)->after('score_a');
            $table->integer('score_c')->default(0)->after('score_b');
            $table->integer('score_d')->default(0)->after('score_c');
            $table->integer('score_e')->default(0)->after('score_d');
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn([
                'question_image', 'image_a', 'image_b', 'image_c', 'image_d', 'image_e',
                'score_a', 'score_b', 'score_c', 'score_d', 'score_e'
            ]);
        });
    }
};