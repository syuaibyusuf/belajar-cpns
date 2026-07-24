<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Soal TWK
        $twkQuestions = [
            [
                'question_text' => 'Pancasila sebagai dasar negara disahkan pada tanggal...',
                'option_a' => '17 Agustus 1945',
                'option_b' => '18 Agustus 1945',
                'option_c' => '1 Juni 1945',
                'option_d' => '22 Juni 1945',
                'option_e' => '17 Juli 1945',
                'correct_answer' => 'b',
                'explanation' => 'Pancasila disahkan bersama UUD 1945 pada sidang PPKI tanggal 18 Agustus 1945'
            ],
            [
                'question_text' => 'Sila pertama Pancasila adalah...',
                'option_a' => 'Kemanusiaan yang adil dan beradab',
                'option_b' => 'Persatuan Indonesia',
                'option_c' => 'Kerakyatan yang dipimpin oleh hikmat kebijaksanaan',
                'option_d' => 'Ketuhanan Yang Maha Esa',
                'option_e' => 'Keadilan sosial bagi seluruh rakyat Indonesia',
                'correct_answer' => 'd',
                'explanation' => 'Sila pertama adalah Ketuhanan Yang Maha Esa'
            ],
            [
                'question_text' => 'Bendera Indonesia disebut...',
                'option_a' => 'Merah Putih',
                'option_b' => 'Sang Saka Merah Putih',
                'option_c' => 'Dwi Warna',
                'option_d' => 'Merah dan Putih',
                'option_e' => 'Sang Merah Putih',
                'correct_answer' => 'b',
                'explanation' => 'Bendera Indonesia disebut Sang Saka Merah Putih'
            ]
        ];

        foreach ($twkQuestions as $q) {
            $q['category'] = 'twk';
            $q['difficulty'] = 'medium';
            Question::create($q);
        }

        // Soal TIU
        $tiuQuestions = [
            [
                'question_text' => 'Sinonim dari kata "KOMPETEN" adalah...',
                'option_a' => 'Bodoh',
                'option_b' => 'Mampu',
                'option_c' => 'Malas',
                'option_d' => 'Pandai',
                'option_e' => 'Cerdik',
                'correct_answer' => 'b',
                'explanation' => 'Kompeten artinya mampu atau cakap'
            ],
            [
                'question_text' => 'Jika 2x + 5 = 15, maka nilai x adalah...',
                'option_a' => '3',
                'option_b' => '4',
                'option_c' => '5',
                'option_d' => '6',
                'option_e' => '7',
                'correct_answer' => 'c',
                'explanation' => '2x = 15 - 5 = 10, maka x = 5'
            ]
        ];

        foreach ($tiuQuestions as $q) {
            $q['category'] = 'tiu';
            $q['difficulty'] = 'medium';
            Question::create($q);
        }

        // Soal TKP
        $tkpQuestions = [
            [
                'question_text' => 'Saat ada tugas kantor yang deadline-nya mepet, sikap Anda...',
                'option_a' => 'Panik dan menyerah',
                'option_b' => 'Bekerja lembur sampai selesai',
                'option_c' => 'Menyalahkan orang lain',
                'option_d' => 'Mencari alasan',
                'option_e' => 'Menunda pekerjaan',
                'correct_answer' => 'b',
                'explanation' => 'Sikap profesional adalah bekerja lembur sampai selesai'
            ]
        ];

        foreach ($tkpQuestions as $q) {
            $q['category'] = 'tkp';
            $q['difficulty'] = 'medium';
            Question::create($q);
        }
    }
}