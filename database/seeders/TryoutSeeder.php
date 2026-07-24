<?php

namespace Database\Seeders;

use App\Models\Tryout;
use App\Models\TryoutQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TryoutSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        TryoutQuestion::truncate();
        Tryout::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $tryouts = [
            [
                'name' => 'Try Out CPNS - Paket 1',
                'description' => 'Simulasi ujian CPNS lengkap dengan soal TWK, TIU, dan TKP.',
                'duration' => 100,
                'twk' => 10, 'tiu' => 10, 'tkp' => 10,
            ],
            [
                'name' => 'Try Out CPNS - Paket 2',
                'description' => 'Simulasi ujian CPNS paket 2 dengan variasi soal berbeda.',
                'duration' => 100,
                'twk' => 10, 'tiu' => 10, 'tkp' => 10,
            ],
            [
                'name' => 'Try Out CPNS - Paket 3 (Sulit)',
                'description' => 'Simulasi ujian CPNS dengan tingkat kesulitan lebih tinggi.',
                'duration' => 90,
                'twk' => 10, 'tiu' => 10, 'tkp' => 10,
            ],
            [
                'name' => 'Try Out CPNS - Paket 4 (Cepat)',
                'description' => 'Simulasi ujian CPNS dengan durasi lebih pendek untuk latihan cepat.',
                'duration' => 60,
                'twk' => 8, 'tiu' => 8, 'tkp' => 8,
            ],
            [
                'name' => 'Try Out CPNS - Paket 5 (Lengkap)',
                'description' => 'Simulasi ujian CPNS terlengkap dengan total 40 soal.',
                'duration' => 120,
                'twk' => 14, 'tiu' => 13, 'tkp' => 13,
            ],
        ];

        $twkPool = [
            ['Pancasila sebagai dasar negara disahkan pada tanggal...', '17 Agustus 1945', '18 Agustus 1945', '1 Juni 1945', '22 Juni 1945', '17 Juli 1945', 'b', 'Disahkan sidang PPKI 18 Agustus 1945'],
            ['Sila pertama Pancasila adalah...', 'Kemanusiaan', 'Persatuan Indonesia', 'Kerakyatan', 'Ketuhanan YME', 'Keadilan Sosial', 'd', 'Sila pertama: Ketuhanan Yang Maha Esa'],
            ['Bhinneka Tunggal Ika dari kitab...', 'Arjunawiwaha', 'Sutasoma', 'Negarakertagama', 'Pararaton', 'Ramayana', 'b', 'Kitab Sutasoma karya Mpu Tantular'],
            ['Bentuk negara Indonesia...', 'Serikat', 'Kesatuan', 'Federal', 'Konfederasi', 'Persemakmuran', 'b', 'Negara kesatuan (Pasal 1 Ayat 1)'],
            ['Lagu kebangsaan...', 'Rayuan Pulau Kelapa', 'Indonesia Raya', 'Garuda Pancasila', 'Halo Bandung', 'Tanah Airku', 'b', 'Indonesia Raya oleh WR Soepratman'],
            ['Hari Kesaktian Pancasila...', '1 Juni', '18 Agustus', '1 Oktober', '28 Oktober', '10 November', 'c', '1 Oktober'],
            ['Sistem pemerintahan RI...', 'Parlementer', 'Presidensial', 'Semipresidensial', 'Monarki', 'Federal', 'b', 'Sistem presidensial'],
            ['Amandemen UUD 1945... kali', '2', '3', '4', '5', '6', 'c', '4 kali (1999-2002)'],
            ['NKRI singkatan dari...', 'Negara Kesatuan RI', 'Negara Kebangsaan RI', 'Nusa Karya RI', 'Negara Kesatuan Rakyat RI', 'Negara Kesejahteraan RI', 'a', 'Negara Kesatuan Republik Indonesia'],
            ['Pembukaan UUD 1945 terdiri dari... alinea', '2', '3', '4', '5', '6', 'c', '4 alinea'],
            ['Semboyan Bhinneka Tunggal Ika artinya...', 'Bersatu teguh', 'Berbeda tetap satu', 'Satu nusa bangsa', 'Indonesia bersatu', 'Kita semua saudara', 'b', 'Berbeda-beda tetapi tetap satu'],
            ['Bendera Indonesia disebut...', 'Merah Putih', 'Sang Saka Merah Putih', 'Dwi Warna', 'Merah dan Putih', 'Sang Merah Putih', 'b', 'Sang Saka Merah Putih'],
            ['Hari Kebangkitan Nasional...', '17 Agustus', '28 Oktober', '20 Mei', '1 Oktober', '10 November', 'c', '20 Mei 1908 (Budi Utomo)'],
            ['Sumpah Pemuda dicetuskan tahun...', '1908', '1928', '1945', '1950', '1966', 'b', '28 Oktober 1928'],
            ['Organisasi pergerakan nasional pertama...', 'Indische Partij', 'Budi Utomo', 'Sarekat Islam', 'Muhammadiyah', 'Perhimpunan Indonesia', 'b', 'Budi Utomo 20 Mei 1908'],
            ['Presiden Indonesia dipilih oleh...', 'MPR', 'DPR', 'Rakyat langsung', 'DPD', 'Partai politik', 'c', 'Pasl 6A UUD 1945: dipilih langsung rakyat'],
            ['Lembaga pengubah UUD adalah...', 'DPR', 'DPD', 'MPR', 'MK', 'MA', 'c', 'MPR berwenang mengubah UUD (Pasal 3)'],
            ['Hari Pahlawan diperingati tiap...', '17 Agustus', '28 Oktober', '10 November', '1 Juni', '20 Mei', 'c', '10 November, pertempuran Surabaya'],
            ['Hak asasi manusia diatur UUD Pasal...', '27-34', '28A-28J', '24-30', '1-5', '31-37', 'b', 'Pasal 28A-28J tentang HAM'],
            ['Nasionalisme mengutamakan...', 'Kepentingan pribadi', 'Kepentingan golongan', 'Kepentingan bangsa', 'Kepentingan internasional', 'Kepentingan daerah', 'c', 'Nasionalisme = kepentingan bangsa di atas segalanya'],
            ['Kewajiban pajak diatur Pasal...', '23', '23A', '23B', '23C', '23D', 'b', 'Pasal 23A UUD 1945'],
            ['Makna sila ke-4 Pancasila...', 'Kekuasaan rakyat via musyawarah', 'Kekuasaan presiden', 'Kekuasaan MPR', 'Kekuasaan partai', 'Kekuasaan mayoritas', 'a', 'Kedaulatan di tangan rakyat via musyawarah mufakat'],
            ['Tokoh proklamator...', 'Soekarno-Hatta', 'Soekarno-Soedirman', 'Hatta-Syahrir', 'Soekarno-Ki Hajar', 'Bung Tomo-Soekarno', 'a', 'Ir. Soekarno dan Drs. Moh. Hatta'],
            ['Konsep Trisakti dicetuskan...', 'Moh. Hatta', 'Soekarno', 'Soeharto', 'Habibie', 'Natsir', 'b', 'Ir. Soekarno: Trisakti'],
            ['Pertempuran Ambarawa dipimpin...', 'Soedirman', 'Isdiman', 'Bung Tomo', 'HB IX', 'Soeharto', 'b', 'Letkol Isdiman'],
        ];

        $tiuPool = [
            ['Sinonim "Kompeten"...', 'Lemah', 'Mampu', 'Bodoh', 'Malas', 'Cerdik', 'b', 'Kompeten = mampu/cakap'],
            ['Antonim "Mayoritas"...', 'Minoritas', 'Sebagian', 'Seluruh', 'Banyak', 'Rata-rata', 'a', 'Mayoritas >< Minoritas'],
            ['2, 4, 6, 8, 10, ...', '11', '12', '13', '14', '15', 'b', 'Pola +2: 10+2=12'],
            ['3 apel Rp15.000, 5 apel?', '20.000', '25.000', '30.000', '35.000', '40.000', 'b', 'Per apel 5.000, 5x5.000=25.000'],
            ['Sinonim "Kontradiksi"...', 'Persamaan', 'Pertentangan', 'Perbedaan', 'Keselarasan', 'Kecocokan', 'b', 'Kontradiksi = pertentangan'],
            ['Kaki : Sepatu = Tangan : ...', 'Sarung Tangan', 'Baju', 'Celana', 'Topi', 'Kacamata', 'a', 'Sepatu di kaki, sarung tangan di tangan'],
            ['Antonim "Modern"...', 'Baru', 'Canggih', 'Kuno', 'Maju', 'Mutakhir', 'c', 'Modern >< Kuno'],
            ['Sinonim "Adaptasi"...', 'Perubahan', 'Penyesuaian', 'Perbaikan', 'Pengembangan', 'Pembaruan', 'b', 'Adaptasi = penyesuaian'],
            ['3, 6, 12, 24, ...', '30', '36', '40', '48', '50', 'd', 'Pola x2: 24x2=48'],
            ['25% dari 200?', '25', '40', '50', '60', '75', 'c', '25/100x200=50'],
            ['1, 4, 9, 16, 25, ...', '30', '35', '36', '40', '49', 'c', 'Pola n²: 6²=36'],
            ['x + 5 = 12, x = ...', '5', '6', '7', '8', '9', 'c', 'x=12-5=7'],
            ['Mobil : Bensin = Manusia : ...', 'Makanan', 'Air', 'Oksigen', 'Vitamin', 'Udara', 'a', 'Bensin > energi, Makanan > energi'],
            ['Persegi sisi 8 cm, luas?', '16', '32', '48', '56', '64', 'e', '8x8=64 cm²'],
            ['Sinonim "Inovatif"...', 'Kreatif', 'Konvensional', 'Tradisional', 'Rutin', 'Biasa', 'a', 'Inovatif = kreatif'],
            ['Antonim "Aktif"...', 'Giat', 'Rajin', 'Pasif', 'Produktif', 'Dinamis', 'c', 'Aktif >< Pasif'],
            ['Sinonim "Edukasi"...', 'Hiburan', 'Pendidikan', 'Pelatihan', 'Pengajaran', 'Pembelajaran', 'b', 'Edukasi = pendidikan'],
            ['100, 96, 92, 88, 84, ...', '80', '82', '78', '76', '74', 'a', 'Pola -4: 84-4=80'],
            ['Jika x+5=12, maka x?...', '5', '6', '7', '8', '9', 'c', 'x=12-5=7'],
            ['Antonim "Konkret"...', 'Nyata', 'Abstrak', 'Jelas', 'Tepat', 'Rill', 'b', 'Konkret >< Abstrak'],
            ['Dokter : Pasien = Guru : ...', 'Siswa', 'RS', 'Sekolah', 'Kelas', 'Buku', 'a', 'Dokter tangani pasien, guru ajar siswa'],
            ['2, 6, 18, 54, 162, ...', '324', '486', '484', '396', '256', 'b', 'Pola x3: 162x3=486'],
            ['120 km/2 jam, kecepatan?', '40 km/j', '50 km/j', '60 km/j', '70 km/j', '80 km/j', 'c', '120/2=60 km/jam'],
            ['Antonim "Legal"...', 'Halal', 'Ilegal', 'Sah', 'Resmi', 'Benar', 'b', 'Legal >< Ilegal'],
            ['Sinonim "Komprehensif"...', 'Terbatas', 'Menyeluruh', 'Sebagian', 'Parsial', 'Khusus', 'b', 'Komprehensif = menyeluruh'],
        ];

        $tkpPool = [
            ['Warga marah mengeluh, sikap Anda?', 'Balas marah', 'Dengar sabar empati', 'Suruh pulang', 'Abaikan', 'Panggil satpam', 'b', 'Mendengar sabar adalah pelayanan prima'],
            ['Rekan langgar ringan, tindakan?', 'Lapor atasan', 'Tegur pribadi sopan', 'Biarkan', 'Ikut langgar', 'Sebar ke rekan', 'b', 'Tegur pribadi adalah langkah pertama tepat'],
            ['Dompet ditemukan, tindakan?', 'Ambil uangnya', 'Serahkan satpam', 'Cari pemilik', 'Pura tak lihat', 'Ambil uang dompet kembali', 'c', 'Kembalikan langsung ke pemilik'],
            ['Atasan kritik hasil kerja?', 'Terima dan perbaiki', 'Marah', 'Terima tak indahkan', 'Salahkan eksternal', 'Minta maaf', 'a', 'Terima kritik dan perbaiki'],
            ['Rekan dapat penghargaan?', 'Bangga termotivasi', 'Iri', 'Biasa', 'Sebar isu', 'Selamat dan minta tips', 'e', 'Ucapkan selamat dan minta tips sukses'],
            ['Tugas deadline mepet?', 'Panik menyerah', 'Lembur sampai selesai', 'Salahkan orang', 'Cari alasan', 'Tunda', 'b', 'Lembur sampai selesai adalah profesional'],
            ['Rapat beda pendapat tajam?', 'Paksakan pendapat', 'Hargai dan cari solusi', 'Diam', 'Keluar', 'Ikut mayoritas', 'b', 'Musyawarah dan hargai pendapat lain'],
            ['Sistem baru di instansi?', 'Tolak', 'Antusias belajar', 'Tunggu rekan', 'Kritik terus', 'Pura bisa', 'b', 'Antusias belajar adaptasi terbaik'],
            ['Proyek gagal, Anda ketua?', 'Salahkan anggota', 'Akui bersama dan evaluasi', 'Menyerah bubar', 'Pura tak tahu', 'Ambil alih sendiri', 'b', 'Akui kesalahan bersama dan evaluasi'],
            ['Dua rekan konflik?', 'Pihak kenal dekat', 'Mediator netral', 'Biarkan', 'Hasut', 'Lapor atasan', 'b', 'Mediator netral adalah yang terbaik'],
            ['Rekan sakit dirawat?', 'Jenguk tawarkan bantuan', 'Abaikan', 'Tanya via rekan', 'Gosip', 'Ambil alih tugas', 'a', 'Jenguk dan tawarkan bantuan'],
            ['Atasan tawari promosi?', 'Terima siap', 'Tolak takut', 'Terima tak serius', 'Minta gantikan', 'Terima syarat', 'a', 'Terima penuh kesiapan dan komitmen'],
            ['Kebijakan baru kurang tepat?', 'Masukan konstruktif', 'Tolak', 'Komentar medsos', 'Diam tak jalan', 'Jalan sambil protes', 'a', 'Masukan konstruktif bentuk kepedulian'],
            ['Lihat kecelakaan?', 'Berhenti tolong', 'Abaikan takut', 'Tonton', 'Video medsos', 'Hubungi polisi', 'a', 'Menolong langsung dan hubungi berwenang'],
            ['Anggaran dipotong, Anda pimpinan?', 'Dana pribadi', 'Usul efisiensi', 'Diam saja', 'Potong sepihak', 'Pinjam pihak3', 'b', 'Usul efisiensi dan prioritas sesuai prosedur'],
            ['Warga buta huruf lansia urus dokumen?', 'Bantu sabar', 'Suruh pulang', 'Bicara keras', 'Abaikan', 'Suruh loket lain', 'a', 'Bantu sabar bahasa sederhana'],
            ['Warga tawari hadiah?', 'Tolak sopan', 'Terima', 'Minta lebih', 'Terima lapor', 'Terima syarat diam', 'a', 'Tolak sopan karena kewajiban'],
            ['Anda sibuk, rekan minta bantuan?', 'Bantu semampu', 'Tolak', 'Bantu ngeluh', 'Pura sibuk', 'Suruh minta lain', 'a', 'Bantu semampunya = gotong royong'],
            ['Kesalahan laporan data?', 'Akui dan perbaiki', 'Salahkan staf', 'Tutupi', 'Pura tak terjadi', 'Koreksi diam-diam', 'a', 'Akui dan perbaiki = integritas'],
            ['Rapat panjang tak efektif?', 'Tetap fokus', 'Tidur', 'Main HP', 'Keluar masuk', 'Usul skors', 'a', 'Tetap fokus adalah profesionalisme'],
            ['Menjadi ketua tim beragam latar?', 'Bagi tugas sesuai kompetensi', 'Otoriter', 'Kerjakan sendiri', 'Beda-bedakan', 'Tugas asal', 'a', 'Hargai perbedaan, bagi tugas sesuai kompetensi'],
            ['Pelatihan di luar kota?', 'Antusias ikuti', 'Malas', 'Ikut tak serius', 'Tolak', 'Ikut jalan-jalan', 'a', 'Antusias mengikuti dan terapkan ilmunya'],
            ['Rekan kewalahan, Anda juga sibuk?', 'Bantu semampu', 'Tolak mentah', 'Bantu ngeluh', 'Pura sibuk', 'Suruh minta lain', 'a', 'Bantu semampunya tanpa abaikan tugas sendiri'],
            ['Warga layanan tak sesuai prosedur?', 'Layani kasihan', 'Jelaskan prosedur cari solusi', 'Suruh pergi', 'Terima imbalan', 'Abaikan', 'b', 'Jelaskan prosedur dan cari solusi alternatif'],
            ['Atasan minta pendapat, belum yakin?', 'Bilang tak tahu', 'Beri pendapat berdasarkan data', 'Diam', 'Buat alasan', 'Bohong yakin', 'b', 'Berikan pendapat berdasarkan data yang ada'],
        ];

        $order = 0;

        foreach ($tryouts as $t) {
            $tryout = Tryout::create([
                'name' => $t['name'],
                'description' => $t['description'],
                'duration' => $t['duration'],
                'total_questions_twk' => $t['twk'],
                'total_questions_tiu' => $t['tiu'],
                'total_questions_tkp' => $t['tkp'],
                'total_questions' => $t['twk'] + $t['tiu'] + $t['tkp'],
                'status' => 'active',
                'created_by' => 1,
            ]);

            $order = 0;

            // TWK
            shuffle($twkPool);
            $selected = array_slice($twkPool, 0, $t['twk']);
            foreach ($selected as $q) {
                $order++;
                TryoutQuestion::create([
                    'tryout_id' => $tryout->id,
                    'order_number' => $order,
                    'category' => 'twk',
                    'question_text' => $q[0],
                    'option_a' => $q[1], 'option_b' => $q[2], 'option_c' => $q[3],
                    'option_d' => $q[4], 'option_e' => $q[5],
                    'correct_answer' => $q[6],
                    'explanation' => $q[7],
                ]);
            }

            // TIU
            shuffle($tiuPool);
            $selected = array_slice($tiuPool, 0, $t['tiu']);
            foreach ($selected as $q) {
                $order++;
                TryoutQuestion::create([
                    'tryout_id' => $tryout->id,
                    'order_number' => $order,
                    'category' => 'tiu',
                    'question_text' => $q[0],
                    'option_a' => $q[1], 'option_b' => $q[2], 'option_c' => $q[3],
                    'option_d' => $q[4], 'option_e' => $q[5],
                    'correct_answer' => $q[6],
                    'explanation' => $q[7],
                ]);
            }

            // TKP
            shuffle($tkpPool);
            $selected = array_slice($tkpPool, 0, $t['tkp']);
            foreach ($selected as $q) {
                $order++;
                TryoutQuestion::create([
                    'tryout_id' => $tryout->id,
                    'order_number' => $order,
                    'category' => 'tkp',
                    'question_text' => $q[0],
                    'option_a' => $q[1], 'option_b' => $q[2], 'option_c' => $q[3],
                    'option_d' => $q[4], 'option_e' => $q[5],
                    'correct_answer' => $q[6],
                    'explanation' => $q[7],
                ]);
            }
        }

        $this->command->info('5 Try Out berhasil dibuat!');
    }
}