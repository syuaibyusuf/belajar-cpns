<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Materi::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $materiList = [
            // Materi TWK
            [
                'title' => 'Pancasila: Dasar Negara Indonesia',
                'category' => 'twk',
                'content' => "PANCASILA\n\n" .
                    "Pancasila adalah dasar negara Indonesia yang terdiri dari 5 sila:\n\n" .
                    "1. Ketuhanan Yang Maha Esa\n" .
                    "   - Mengakui dan meyakini adanya Tuhan Yang Maha Esa\n" .
                    "   - Menghormati pemeluk agama lain\n" .
                    "   - Kerukunan antar umat beragama\n\n" .
                    "2. Kemanusiaan yang Adil dan Beradab\n" .
                    "   - Mengakui persamaan derajat manusia\n" .
                    "   - Menjunjung tinggi nilai kemanusiaan\n" .
                    "   - Berbuat adil kepada sesama\n\n" .
                    "3. Persatuan Indonesia\n" .
                    "   - Cinta tanah air dan bangsa\n" .
                    "   - Rela berkorban untuk kepentingan bangsa\n" .
                    "   - Bangga sebagai bangsa Indonesia\n\n" .
                    "4. Kerakyatan yang Dipimpin oleh Hikmat Kebijaksanaan\n" .
                    "   - Mengutamakan musyawarah untuk mencapai mufakat\n" .
                    "   - Menghargai pendapat orang lain\n" .
                    "   - Melaksanakan keputusan bersama\n\n" .
                    "5. Keadilan Sosial bagi Seluruh Rakyat Indonesia\n" .
                    "   - Keseimbangan hak dan kewajiban\n" .
                    "   - Gotong royong dalam masyarakat\n" .
                    "   - Pemerataan pembangunan",
                'order_number' => 1,
                'status' => 'published'
            ],
            [
                'title' => 'UUD 1945: Konstitusi Negara',
                'category' => 'twk',
                'content' => "UUD 1945\n\n" .
                    "Undang-Undang Dasar Negara Republik Indonesia Tahun 1945 adalah konstitusi tertulis yang menjadi dasar hukum tertinggi di Indonesia.\n\n" .
                    "Sejarah Singkat:\n" .
                    "- Disahkan pada tanggal 18 Agustus 1945\n" .
                    "- Terdiri dari Pembukaan dan pasal-pasal\n" .
                    "- Telah mengalami 4 kali amandemen (1999-2002)\n\n" .
                    "Pembukaan UUD 1945 Alinea 4 berisi:\n" .
                    "1. Tujuan negara\n" .
                    "2. Dasar negara (Pancasila)\n" .
                    "3. Bentuk negara (Republik)\n" .
                    "4. Sistem pemerintahan",
                'order_number' => 2,
                'status' => 'published'
            ],
            [
                'title' => 'Bhinneka Tunggal Ika',
                'category' => 'twk',
                'content' => "BHINNEKA TUNGGAL IKA\n\n" .
                    "Bhinneka Tunggal Ika adalah motto atau semboyan bangsa Indonesia.\n\n" .
                    "Arti: 'Berbeda-beda tetapi tetap satu'\n\n" .
                    "Sejarah:\n" .
                    "- Diambil dari kitab Sutasoma karya Mpu Tantular (zaman Kerajaan Majapahit)\n" .
                    "- Disahkan sebagai semboyan negara pada tanggal 17 Agustus 1950\n\n" .
                    "Makna:\n" .
                    "- Keberagaman suku, agama, ras, dan golongan\n" .
                    "- Persatuan dalam perbedaan\n" .
                    "- Toleransi dan kerukunan",
                'order_number' => 3,
                'status' => 'published'
            ],
            
            // Materi TIU
            [
                'title' => 'Tips Mengerjakan Soal Sinonim',
                'category' => 'tiu',
                'content' => "SINONIM (Persamaan Kata)\n\n" .
                    "Sinonim adalah kata yang memiliki makna sama atau hampir sama.\n\n" .
                    "Tips mengerjakan:\n" .
                    "1. Pahami arti kata dasar\n" .
                    "2. Cari kata yang memiliki makna paling dekat\n" .
                    "3. Perhatikan konteks kalimat\n\n" .
                    "Contoh:\n" .
                    "- Kompeten = Mampu\n" .
                    "- Kontradiksi = Pertentangan\n" .
                    "- Adaptasi = Penyesuaian\n" .
                    "- Inovatif = Kreatif",
                'order_number' => 1,
                'status' => 'published'
            ],
            [
                'title' => 'Tips Mengerjakan Soal Antonim',
                'category' => 'tiu',
                'content' => "ANTONIM (Lawan Kata)\n\n" .
                    "Antonim adalah kata yang memiliki makna berlawanan.\n\n" .
                    "Tips mengerjakan:\n" .
                    "1. Pahami arti kata yang ditanyakan\n" .
                    "2. Cari lawan kata yang paling tepat\n" .
                    "3. Perhatikan imbuhan yang bisa membalikkan makna\n\n" .
                    "Contoh:\n" .
                    "- Mayoritas = Minoritas\n" .
                    "- Modern = Kuno\n" .
                    "- Aktif = Pasif\n" .
                    "- Konkret = Abstrak",
                'order_number' => 2,
                'status' => 'published'
            ],
            [
                'title' => 'Deret Angka dan Logika Aritmatika',
                'category' => 'tiu',
                'content' => "DERET ANGKA DAN LOGIKA ARITMATIKA\n\n" .
                    "Pola Deret Angka:\n\n" .
                    "1. Aritmatika (penjumlahan/pengurangan)\n" .
                    "   Contoh: 2, 4, 6, 8, ... (ditambah 2)\n\n" .
                    "2. Geometri (perkalian/pembagian)\n" .
                    "   Contoh: 3, 6, 12, 24, ... (dikali 2)\n\n" .
                    "3. Pola campuran\n" .
                    "   Contoh: 2, 3, 5, 7, 11, ... (bilangan prima)\n\n" .
                    "Tips:\n" .
                    "- Cari beda/selisih antar angka\n" .
                    "- Cek pola berulang\n" .
                    "- Perhatikan operasi bergantian",
                'order_number' => 3,
                'status' => 'published'
            ],
            
            // Materi TKP
            [
                'title' => 'Integritas dan Profesionalisme ASN',
                'category' => 'tkp',
                'content' => "INTEGRITAS DAN PROFESIONALISME ASN\n\n" .
                    "Integritas ASN:\n" .
                    "- Jujur dan konsisten antara ucapan dan tindakan\n" .
                    "- Tidak korupsi dan tidak menyalahgunakan wewenang\n" .
                    "- Berani mengatakan kebenaran\n\n" .
                    "Profesionalisme:\n" .
                    "- Bekerja sesuai standar prosedur\n" .
                    "- Meningkatkan kompetensi diri\n" .
                    "- Bertanggung jawab atas tugas\n\n" .
                    "Sikap yang diharapkan:\n" .
                    "- Disiplin dan tepat waktu\n" .
                    "- Berorientasi pada hasil\n" .
                    "- Melayani dengan tulus",
                'order_number' => 1,
                'status' => 'published'
            ],
            [
                'title' => 'Pelayanan Publik yang Prima',
                'category' => 'tkp',
                'content' => "PELAYANAN PUBLIK\n\n" .
                    "Prinsip Pelayanan Prima:\n\n" .
                    "1. Ramah dan Sopan\n" .
                    "   - Senyum, sapa, salam\n" .
                    "   - Gunakan bahasa yang baik\n\n" .
                    "2. Cepat dan Tepat\n" .
                    "   - Proses pelayanan efisien\n" .
                    "   - Kurangi birokrasi berbelit\n\n" .
                    "3. Transparan\n" .
                    "   - Informasi jelas dan mudah diakses\n" .
                    "   - Prosedur pelayanan terbuka\n\n" .
                    "4. Akuntabel\n" .
                    "   - Dapat dipertanggungjawabkan\n" .
                    "   - Ada standar pelayanan",
                'order_number' => 2,
                'status' => 'published'
            ],
            [
                'title' => 'Kerjasama Tim dan Adaptasi',
                'category' => 'tkp',
                'content' => "KERJASAMA TIM DAN ADAPTASI\n\n" .
                    "Kerjasama Tim:\n" .
                    "- Mampu bekerja dalam kelompok\n" .
                    "- Menghargai pendapat orang lain\n" .
                    "- Komunikasi yang efektif\n" .
                    "- Saling membantu dan mendukung\n\n" .
                    "Kemampuan Adaptasi:\n" .
                    "- Fleksibel terhadap perubahan\n" .
                    "- Cepat belajar hal baru\n" .
                    "- Tidak kaku dengan aturan lama\n" .
                    "- Mampu bekerja di berbagai situasi\n\n" .
                    "Sikap yang baik:\n" .
                    "- Terbuka terhadap kritik\n" .
                    "- Mau mendengar saran\n" .
                    "- Berbagi pengetahuan dengan rekan",
                'order_number' => 3,
                'status' => 'published'
            ]
        ];

        foreach ($materiList as $m) {
            Materi::create($m);
        }
        
        echo "Seeder berhasil: " . Materi::count() . " materi ditambahkan\n";
    }
}