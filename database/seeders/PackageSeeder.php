<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageQuestion;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh paket TWK
        $package = Package::create([
            'name' => 'Try Out TWK 1',
            'category' => 'twk',
            'description' => 'Paket latihan TWK 10 soal untuk menguji wawasan kebangsaan',
            'total_questions' => 10,
            'status' => 'active',
            'created_by' => 1
        ]);
        
        // Contoh soal untuk paket
        $questions = [
            [
                'order_number' => 1,
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
                'order_number' => 2,
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
                'order_number' => 3,
                'question_text' => 'Bendera Indonesia disebut...',
                'option_a' => 'Merah Putih',
                'option_b' => 'Sang Saka Merah Putih',
                'option_c' => 'Dwi Warna',
                'option_d' => 'Merah dan Putih',
                'option_e' => 'Sang Merah Putih',
                'correct_answer' => 'b',
                'explanation' => 'Bendera Indonesia disebut Sang Saka Merah Putih'
            ],
            [
                'order_number' => 4,
                'question_text' => 'Lagu kebangsaan Indonesia adalah...',
                'option_a' => 'Indonesia Raya',
                'option_b' => 'Rayuan Pulau Kelapa',
                'option_c' => 'Garuda Pancasila',
                'option_d' => 'Halo-halo Bandung',
                'option_e' => 'Tanah Airku',
                'correct_answer' => 'a',
                'explanation' => 'Lagu kebangsaan Indonesia adalah Indonesia Raya karya WR Supratman'
            ],
            [
                'order_number' => 5,
                'question_text' => 'Semboyan Bhinneka Tunggal Ika berarti...',
                'option_a' => 'Bersatu kita teguh',
                'option_b' => 'Berbeda-beda tetapi tetap satu',
                'option_c' => 'Satu nusa satu bangsa',
                'option_d' => 'Indonesia bersatu',
                'option_e' => 'Kita semua saudara',
                'correct_answer' => 'b',
                'explanation' => 'Bhinneka Tunggal Ika berarti berbeda-beda tetapi tetap satu'
            ]
        ];
        
        for ($i = 6; $i <= 10; $i++) {
            $questions[] = [
                'order_number' => $i,
                'question_text' => 'Contoh soal TWK nomor ' . $i,
                'option_a' => 'Pilihan A',
                'option_b' => 'Pilihan B',
                'option_c' => 'Pilihan C',
                'option_d' => 'Pilihan D',
                'option_e' => 'Pilihan E',
                'correct_answer' => 'a',
                'explanation' => 'Pembahasan untuk soal nomor ' . $i
            ];
        }
        
        foreach ($questions as $q) {
            $q['package_id'] = $package->id;
            PackageQuestion::create($q);
        }
        
        echo "Paket contoh berhasil dibuat!\n";
    }
}