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
            ['Pancasila sebagai dasar negara disahkan pada tanggal...', '17 Agustus 1945', '18 Agustus 1945', '1 Juni 1945', '22 Juni 1945', '17 Juli 1945', 'b', 'Disahkan sidang PPKI 18 Agustus 1945'],
            ['Sila pertama Pancasila adalah...', 'Kemanusiaan', 'Persatuan Indonesia', 'Kerakyatan', 'Ketuhanan YME', 'Keadilan Sosial', 'd', 'Sila pertama: Ketuhanan Yang Maha Esa'],
            ['Bhinneka Tunggal Ika berasal dari kitab...', 'Arjunawiwaha', 'Sutasoma', 'Negarakertagama', 'Pararaton', 'Ramayana', 'b', 'Kitab Sutasoma karya Mpu Tantular'],
            ['Bentuk negara Indonesia adalah...', 'Serikat', 'Kesatuan', 'Federal', 'Konfederasi', 'Persemakmuran', 'b', 'Negara kesatuan (Pasal 1 Ayat 1)'],
            ['Lagu kebangsaan Indonesia...', 'Rayuan Pulau Kelapa', 'Indonesia Raya', 'Garuda Pancasila', 'Halo Bandung', 'Tanah Airku', 'b', 'Indonesia Raya oleh WR Soepratman'],
            ['Hari Kesaktian Pancasila...', '1 Juni', '18 Agustus', '1 Oktober', '28 Oktober', '10 November', 'c', '1 Oktober'],
            ['Sistem pemerintahan RI...', 'Parlementer', 'Presidensial', 'Semipresidensial', 'Monarki', 'Federal', 'b', 'Sistem presidensial'],
            ['UUD 1945 amandemen... kali', '2', '3', '4', '5', '6', 'c', '4 kali (1999-2002)'],
            ['NKRI singkatan dari...', 'Negara Kesatuan RI', 'Negara Kebangsaan RI', 'Nusa Karya RI', 'Negara Kesatuan Rakyat RI', 'Negara Kesejahteraan RI', 'a', 'Negara Kesatuan Republik Indonesia'],
            ['Pembukaan UUD 1945 terdiri... alinea', '2', '3', '4', '5', '6', 'c', '4 alinea'],
        ];

        foreach ($twkQuestions as $q) {
            Question::create([
                'category' => 'twk',
                'question_text' => $q[0],
                'option_a' => $q[1], 'option_b' => $q[2], 'option_c' => $q[3],
                'option_d' => $q[4], 'option_e' => $q[5],
                'correct_answer' => $q[6],
                'explanation' => $q[7],
                'difficulty' => 'medium',
            ]);
        }

        // Soal TIU
        $tiuQuestions = [
            ['Sinonim "Kompeten"...', 'Lemah', 'Mampu', 'Bodoh', 'Malas', 'Cerdik', 'b', 'Kompeten = mampu'],
            ['Antonim "Mayoritas"...', 'Minoritas', 'Sebagian', 'Seluruh', 'Banyak', 'Rata-rata', 'a', 'Mayoritas >< Minoritas'],
            ['2, 4, 6, 8, 10, ...', '11', '12', '13', '14', '15', 'b', 'Pola +2: 10+2=12'],
            ['3 apel Rp15.000, 5 apel?', '20.000', '25.000', '30.000', '35.000', '40.000', 'b', 'Per apel 5.000'],
            ['Sinonim "Kontradiksi"...', 'Persamaan', 'Pertentangan', 'Perbedaan', 'Keselarasan', 'Kecocokan', 'b', 'Kontradiksi = pertentangan'],
            ['Antonim "Modern"...', 'Baru', 'Canggih', 'Kuno', 'Maju', 'Mutakhir', 'c', 'Modern >< Kuno'],
            ['Sinonim "Adaptasi"...', 'Perubahan', 'Penyesuaian', 'Perbaikan', 'Pengembangan', 'Pembaruan', 'b', 'Adaptasi = penyesuaian'],
            ['3, 6, 12, 24, ...', '30', '36', '40', '48', '50', 'd', 'Pola x2: 24x2=48'],
            ['25% dari 200?', '25', '40', '50', '60', '75', 'c', '25/100x200=50'],
            ['x + 5 = 12, x = ...', '5', '6', '7', '8', '9', 'c', 'x=12-5=7'],
        ];

        foreach ($tiuQuestions as $q) {
            Question::create([
                'category' => 'tiu',
                'question_text' => $q[0],
                'option_a' => $q[1], 'option_b' => $q[2], 'option_c' => $q[3],
                'option_d' => $q[4], 'option_e' => $q[5],
                'correct_answer' => $q[6],
                'explanation' => $q[7],
                'difficulty' => 'medium',
            ]);
        }

        // Soal TKP
        $tkpQuestions = [
            ['Tugas deadline mepet, sikap?', 'Panik menyerah', 'Lembur selesai', 'Salahkan orang', 'Cari alasan', 'Tunda', 'b', 'Lembur sampai selesai = profesional'],
            ['Rekan sakit dirawat, sikap?', 'Jenguk bantu', 'Abaikan', 'Tanya rekan', 'Gosip', 'Ambil tugas', 'a', 'Jenguk dan tawarkan bantuan'],
            ['Atasan kritik hasil kerja?', 'Terima perbaiki', 'Marah', 'Terima cuek', 'Salahkan pihak lain', 'Minta maaf', 'a', 'Terima kritik dan perbaiki'],
            ['Rapat beda pendapat?', 'Paksakan', 'Hargai cari solusi', 'Diam', 'Keluar', 'Ikut mayoritas', 'b', 'Hargai pendapat dan cari solusi bersama'],
            ['Dompet ditemukan?', 'Ambil uang', 'Serahkan satpam', 'Cari pemilik', 'Pura lihat', 'Ambil uang dompet kembali', 'c', 'Cari pemilik dan kembalikan'],
            ['Warga marah mengeluh?', 'Balas marah', 'Dengar sabar', 'Suruh pulang', 'Abaikan', 'Panggil satpam', 'b', 'Dengar dengan sabar dan empati'],
            ['Rekan langgar ringan?', 'Lapor atasan', 'Tegur pribadi', 'Biarkan', 'Ikuti', 'Sebarkan', 'b', 'Tegur pribadi dengan sopan'],
            ['Rekan dapat penghargaan?', 'Bangga motivasi', 'Iri', 'Biasa', 'Sebar isu', 'Selamat minta tips', 'e', 'Ucapkan selamat dan minta tips'],
            ['Sistem baru di kantor?', 'Tolak', 'Antusias belajar', 'Tunggu rekan', 'Kritik', 'Pura bisa', 'b', 'Antusias belajar dan beradaptasi'],
            ['Proyek gagal sebagai ketua?', 'Salahkan anggota', 'Akui evaluasi', 'Bubarkan', 'Pura tak tahu', 'Ambil alih sendiri', 'b', 'Akui kesalahan dan evaluasi bersama'],
        ];

        foreach ($tkpQuestions as $q) {
            Question::create([
                'category' => 'tkp',
                'question_text' => $q[0],
                'option_a' => $q[1], 'option_b' => $q[2], 'option_c' => $q[3],
                'option_d' => $q[4], 'option_e' => $q[5],
                'correct_answer' => $q[6],
                'explanation' => $q[7],
                'difficulty' => 'medium',
            ]);
        }
    }
}