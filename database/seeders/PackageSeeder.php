<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        PackageQuestion::truncate();
        Package::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $packages = [
            [
                'name' => 'Paket TWK - Wawasan Kebangsaan',
                'category' => 'twk',
                'description' => 'Latihan soal TWK untuk menguji pemahaman kebangsaan, Pancasila, UUD 1945, dan Bhinneka Tunggal Ika.',
                'questions' => [
                    ['Pancasila sebagai dasar negara disahkan pada tanggal...', '17 Agustus 1945', '18 Agustus 1945', '1 Juni 1945', '22 Juni 1945', '17 Juli 1945', 'b', 'Pancasila disahkan pada sidang PPKI 18 Agustus 1945'],
                    ['Sila pertama Pancasila adalah...', 'Kemanusiaan yg adil dan beradab', 'Persatuan Indonesia', 'Kerakyatan yg dipimpin hikmat', 'Ketuhanan Yang Maha Esa', 'Keadilan sosial bagi seluruh rakyat', 'd', 'Sila pertama adalah Ketuhanan Yang Maha Esa'],
                    ['Bhinneka Tunggal Ika berasal dari kitab...', 'Arjunawiwaha', 'Sutasoma', 'Negarakertagama', 'Pararaton', 'Ramayana', 'b', 'Berasal dari kitab Sutasoma karya Mpu Tantular'],
                    ['Pembukaan UUD 1945 terdiri dari... alinea', '2', '3', '4', '5', '6', 'c', 'Pembukaan UUD 1945 terdiri dari 4 alinea'],
                    ['Bentuk negara Indonesia adalah...', 'Serikat', 'Kesatuan', 'Federal', 'Konfederasi', 'Persemakmuran', 'b', 'Indonesia adalah negara kesatuan (Pasal 1 Ayat 1 UUD 1945)'],
                    ['Lagu kebangsaan Indonesia adalah...', 'Rayuan Pulau Kelapa', 'Indonesia Raya', 'Garuda Pancasila', 'Halo-halo Bandung', 'Tanah Airku', 'b', 'Indonesia Raya ciptaan WR Soepratman'],
                    ['Hari Kesaktian Pancasila diperingati tiap tanggal...', '1 Juni', '18 Agustus', '1 Oktober', '28 Oktober', '10 November', 'c', 'Hari Kesaktian Pancasila 1 Oktober'],
                    ['Sistem pemerintahan Indonesia adalah...', 'Parlementer', 'Presidensial', 'Semipresidensial', 'Monarki', 'Federal', 'b', 'Indonesia menganut sistem presidensial'],
                    ['UUD 1945 telah diamandemen sebanyak... kali', '2', '3', '4', '5', '6', 'c', 'Amandemen UUD 1945: 1999, 2000, 2001, 2002'],
                    ['NKRI adalah singkatan dari...', 'Negara Kesatuan Republik Indonesia', 'Negara Kebangsaan RI', 'Nusa Karya Rakyat Indonesia', 'Negara Kesatuan Rakyat Indonesia', 'Negara Kesejahteraan RI', 'a', 'NKRI = Negara Kesatuan Republik Indonesia'],
                ]
            ],
            [
                'name' => 'Paket TIU - Sinonim & Antonim',
                'category' => 'tiu',
                'description' => 'Latihan soal TIU fokus pada sinonim, antonim, dan analogi kata.',
                'questions' => [
                    ['Sinonim dari kata "Kompeten" adalah...', 'Lemah', 'Mampu', 'Bodoh', 'Malas', 'Cerdik', 'b', 'Kompeten berarti mampu atau cakap'],
                    ['Antonim dari kata "Mayoritas" adalah...', 'Minoritas', 'Sebagian', 'Seluruh', 'Banyak', 'Rata-rata', 'a', 'Mayoritas >< Minoritas'],
                    ['Sinonim dari kata "Kontradiksi" adalah...', 'Persamaan', 'Pertentangan', 'Perbedaan', 'Keselarasan', 'Kecocokan', 'b', 'Kontradiksi = pertentangan'],
                    ['Antonim dari kata "Modern" adalah...', 'Baru', 'Canggih', 'Kuno', 'Maju', 'Mutakhir', 'c', 'Modern >< Kuno'],
                    ['Sinonim dari kata "Adaptasi" adalah...', 'Perubahan', 'Penyesuaian', 'Perbaikan', 'Pengembangan', 'Pembaruan', 'b', 'Adaptasi = penyesuaian'],
                    ['Kaki : Sepatu = Tangan : ...', 'Sarung Tangan', 'Baju', 'Celana', 'Topi', 'Kacamata', 'a', 'Sepatu dipakai di kaki, sarung tangan di tangan'],
                    ['Antonim dari kata "Konkret" adalah...', 'Nyata', 'Abstrak', 'Jelas', 'Tepat', 'Rill', 'b', 'Konkret >< Abstrak'],
                    ['Sinonim dari kata "Inovatif" adalah...', 'Kreatif', 'Konvensional', 'Tradisional', 'Rutin', 'Biasa', 'a', 'Inovatif = kreatif'],
                    ['Antonim dari kata "Aktif" adalah...', 'Giat', 'Rajin', 'Pasif', 'Produktif', 'Dinamis', 'c', 'Aktif >< Pasif'],
                    ['Sinonim dari kata "Edukasi" adalah...', 'Hiburan', 'Pendidikan', 'Pelatihan', 'Pengajaran', 'Pembelajaran', 'b', 'Edukasi = pendidikan'],
                ]
            ],
            [
                'name' => 'Paket TIU - Numerik & Logika',
                'category' => 'tiu',
                'description' => 'Latihan soal TIU fokus pada deret angka, aritmatika, dan penalaran logis.',
                'questions' => [
                    ['2, 4, 6, 8, 10, ... Angka selanjutnya?', '11', '12', '13', '14', '15', 'b', 'Pola +2: 10+2=12'],
                    ['Jika 3 apel Rp15.000, harga 5 apel?', 'Rp20.000', 'Rp25.000', 'Rp30.000', 'Rp35.000', 'Rp40.000', 'b', 'Per apel = 5.000, 5 apel = 25.000'],
                    ['1, 3, 5, 7, 9, ... Angka selanjutnya?', '10', '11', '12', '13', '14', 'b', 'Bilangan ganjil: setelah 9 adalah 11'],
                    ['3, 6, 12, 24, ... Angka selanjutnya?', '30', '36', '40', '48', '50', 'd', 'Pola x2: 24x2=48'],
                    ['Berapa 25% dari 200?', '25', '40', '50', '60', '75', 'c', '25/100 x 200 = 50'],
                    ['Semua mahasiswa lulusan SMA. Sebagian mahasiswa pekerja paruh waktu. Kesimpulan?', 'Semua pekerja paruh waktu lulusan SMA', 'Sebagian pekerja paruh waktu lulusan SMA', 'Semua lulusan SMA adalah mahasiswa', 'Sebagian lulusan SMA pekerja paruh waktu', 'Tidak ada kesimpulan', 'b', 'Sebagian pekerja paruh waktu adalah lulusan SMA'],
                    ['1, 4, 9, 16, 25, ... Angka selanjutnya?', '30', '35', '36', '40', '49', 'c', 'Pola n²: 6²=36'],
                    ['Jika x + 5 = 12, maka x = ...', '5', '6', '7', '8', '9', 'c', 'x = 12-5 = 7'],
                    ['Mobil : Bensin = Manusia : ...', 'Makanan', 'Air', 'Oksigen', 'Vitamin', 'Udara', 'a', 'Bensin sumber energi mobil, makanan sumber energi manusia'],
                    ['Sebuah persegi sisi 8 cm. Luasnya?', '16 cm²', '32 cm²', '48 cm²', '56 cm²', '64 cm²', 'e', '8x8 = 64 cm²'],
                ]
            ],
            [
                'name' => 'Paket TKP - Pelayanan Publik',
                'category' => 'tkp',
                'description' => 'Latihan soal TKP fokus pada pelayanan publik, integritas, dan profesionalisme ASN.',
                'questions' => [
                    ['Warga datang mengeluh marah. Sikap Anda?', 'Menjawab nada keras', 'Dengar dengan sabar empati', 'Suruh pergi besok', 'Abaikan pura sibuk', 'Panggil satpam', 'b', 'Mendengar sabar dan empati adalah pelayanan prima'],
                    ['Rekan kerja melanggar ringan. Tindakan Anda?', 'Lapor atasan langsung', 'Tegur pribadi sopan', 'Biarkan saja', 'Ikut melanggar', 'Sebar ke rekan lain', 'b', 'Tegur pribadi dengan baik adalah langkah pertama tepat'],
                    ['Dompet ditemukan di kantin. Tindakan?', 'Ambil uangnya buang KTP', 'Serahkan ke satpam/umum', 'Cari pemilik, kembalikan', 'Pura tidak lihat', 'Ambil uang, dompet dikembalikan', 'c', 'Mengembalikan langsung ke pemilik adalah paling terpuji'],
                    ['Atasan kritik hasil kerja. Sikap Anda?', 'Terima lapang dan perbaiki', 'Marah dan bantah', 'Terima tapi tak diindahkan', 'Salahkan faktor eksternal', 'Minta maaf janji perbaiki', 'a', 'Menerima kritik dan memperbaiki adalah sikap terbaik'],
                    ['Rekan kerja dapat penghargaan. Sikap Anda?', 'Bangga dan termotivasi', 'Iri dan remehkan', 'Biasa saja', 'Sebar isu curang', 'Ucap selamat dan minta tips', 'e', 'Mengucapkan selamat dan minta tips adalah positif'],
                    ['Warga buta huruf lansia urus dokumen. Sikap?', 'Bantu sabar bahasa sederhana', 'Suruh pulang cari pendamping', 'Bicara keras', 'Abaikan layani yg lain', 'Suruh ke loket lain', 'a', 'Membantu sabar dengan bahasa sederhana adalah pelayanan prima'],
                    ['Warga tawari hadiah setelah dibantu. Sikap?', 'Tolak sopan karena kewajiban', 'Terima karena sudah bantu', 'Minta lebih', 'Terima dan lapor atasan', 'Terima dengan syarat diam', 'a', 'Menolak dengan sopan adalah sikap paling berintegritas'],
                    ['Rekan kerja sakit dirawat. Sikap Anda?', 'Jenguk dan tawarkan bantuan', 'Abaikan bukan kerabat', 'Tanya via rekan lain', 'Gosip penyakitnya', 'Ambil alih tugas tanpa koordinasi', 'a', 'Menjenguk langsung dan menawarkan bantuan adalah kepedulian'],
                    ['Tugas deadline mepet. Sikap Anda?', 'Panik dan menyerah', 'Kerja lembur sampai selesai', 'Salahkan orang lain', 'Cari alasan', 'Tunda pekerjaan', 'b', 'Bekerja lembur sampai selesai adalah profesional'],
                    ['Anda melakukan kesalahan laporan. Sikap?', 'Akui dan segera perbaiki', 'Salahkan staf/rekan', 'Tutup-nutupi', 'Pura-pura tidak terjadi', 'Koreksi diam-diam', 'a', 'Mengakui dan memperbaiki adalah integritas tertinggi'],
                ]
            ],
            [
                'name' => 'Paket TKP - Kerjasama & Adaptasi',
                'category' => 'tkp',
                'description' => 'Latihan soal TKP fokus pada kerja sama tim, adaptasi, dan kepemimpinan.',
                'questions' => [
                    ['Rapat perbedaan pendapat tajam. Sikap Anda?', 'Paksakan pendapat sendiri', 'Hargai pendapat lain cari solusi', 'Diam saja', 'Keluar ruangan', 'Ikut mayoritas tanpa pikir', 'b', 'Musyawarah dan menghargai pendapat lain adalah terbaik'],
                    ['Instansi pakai sistem informasi baru. Sikap?', 'Tolak karena nyaman lama', 'Antusias belajar dan adaptasi', 'Tunggu rekan lalu tiru', 'Kritik terus tanpa mau belajar', 'Pura-pura sudah bisa', 'b', 'Antusias belajar adalah adaptasi terbaik'],
                    ['Proyek tim gagal. Anda ketua tim. Sikap?', 'Salahkan anggota', 'Akui kesalahan bersama dan evaluasi', 'Menyerah bubarkan tim', 'Pura tidak tahu', 'Ambil alih sendiri', 'b', 'Mengakui kesalahan bersama dan evaluasi adalah kepemimpinan sejati'],
                    ['Dua rekan konflik saling menjelekkan. Sikap?', 'Pihak yg dikenal dekat', 'Damaikan jadi mediator netral', 'Biarkan bukan urusan saya', 'Hasut agar makin besar', 'Lapor atasan tanpa mediasi', 'b', 'Menjadi mediator netral adalah yang terbaik'],
                    ['Anda sibuk, rekan minta bantuan kewalahan. Sikap?', 'Bantu semampu saya', 'Tolak mentah-mentah', 'Bantu setengah hati sambil ngeluh', 'Pura-pura sibuk', 'Suruh minta tolong orang lain', 'a', 'Membantu semampu mungkin adalah gotong royong'],
                    ['Atasan tawari promosi jabatan besar. Sikap?', 'Terima penuh kesiapan', 'Tolak takut gagal', 'Terima tak serius', 'Minta orang lain gantikan', 'Terima dengan syarat', 'a', 'Menerima dengan kesiapan penuh adalah sikap terbaik'],
                    ['Kebijakan baru kurang tepat. Sikap Anda?', 'Sampaikan masukan konstruktif', 'Tolak tak laksanakan', 'Komentar negatif di medsos', 'Diam tapi tak jalankan', 'Jalankan sambil protes', 'a', 'Masukan konstruktif adalah bentuk kepedulian terbaik'],
                    ['Lihat kecelakaan di jalan. Tindakan?', 'Berhenti tolong seperlunya', 'Abaikan takut terlibat', 'Tonton dari jauh', 'Ambil video untuk medsos', 'Hubungi polisi lalu pergi', 'a', 'Menolong langsung dan hubungi berwenang adalah terpuji'],
                    ['Anggaran instansi dipotong. Anda pimpinan. Sikap?', 'Pakai dana pribadi', 'Usul efisiensi dan prioritas', 'Diam terima apa adanya', 'Potong anggaran sepihak', 'Cari pinjaman pihak ketiga', 'b', 'Mengusulkan efisiensi adalah solusi terbaik sesuai prosedur'],
                    ['Rekan dirawat di rumah sakit. Sikap Anda?', 'Jenguk dan tawarkan bantuan', 'Abaikan bukan keluarga', 'Tanya kabar lewat rekan', 'Gosip tentang penyakitnya', 'Ambil alih tugas tanpa koordinasi', 'a', 'Menjenguk langsung dan menawarkan bantuan adalah sikap peduli'],
                ]
            ],
        ];

        $questions = [];

        // Simpan dulu semua package tanpa questions untuk mendapatkan ID
        foreach ($packages as $pkg) {
            $package = Package::create([
                'name' => $pkg['name'],
                'category' => $pkg['category'],
                'description' => $pkg['description'],
                'total_questions' => count($pkg['questions']),
                'status' => 'active',
                'created_by' => 1,
            ]);

            foreach ($pkg['questions'] as $i => $q) {
                PackageQuestion::create([
                    'package_id' => $package->id,
                    'order_number' => $i + 1,
                    'question_text' => $q[0],
                    'option_a' => $q[1],
                    'option_b' => $q[2],
                    'option_c' => $q[3],
                    'option_d' => $q[4],
                    'option_e' => $q[5],
                    'correct_answer' => $q[6],
                    'explanation' => $q[7],
                ]);
            }
        }

        $this->command->info('5 Paket Soal berhasil dibuat!');
    }
}