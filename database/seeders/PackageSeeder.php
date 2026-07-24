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
            // ==================== TWK (5 PAKET) ====================
            [
                'name' => 'TWK - Pancasila & UUD 1945',
                'category' => 'twk',
                'description' => 'Latihan soal TWK tentang Pancasila sebagai dasar negara dan UUD 1945 sebagai konstitusi.',
                'questions' => [
                    ['Pancasila sebagai dasar negara disahkan pada tanggal...', '17 Agustus 1945', '18 Agustus 1945', '1 Juni 1945', '22 Juni 1945', '17 Juli 1945', 'b', 'Disahkan sidang PPKI 18 Agustus 1945'],
                    ['Sila pertama Pancasila adalah...', 'Kemanusiaan', 'Persatuan Indonesia', 'Kerakyatan', 'Ketuhanan YME', 'Keadilan Sosial', 'd', 'Sila pertama: Ketuhanan Yang Maha Esa'],
                    ['Pembukaan UUD 1945 terdiri dari... alinea', '2', '3', '4', '5', '6', 'c', '4 alinea'],
                    ['Bentuk negara Indonesia adalah...', 'Serikat', 'Kesatuan', 'Federal', 'Konfederasi', 'Persemakmuran', 'b', 'Negara kesatuan (Pasal 1 Ayat 1)'],
                    ['UUD 1945 telah diamandemen sebanyak... kali', '2', '3', '4', '5', '6', 'c', '4 kali (1999-2002)'],
                    ['Lembaga yang berwenang mengubah UUD adalah...', 'DPR', 'DPD', 'MPR', 'MK', 'MA', 'c', 'MPR (Pasal 3 UUD 1945)'],
                    ['Pasal dalam UUD 1945 yang mengatur HAM adalah...', '27-34', '28A-28J', '24-30', '1-5', '31-37', 'b', 'Pasal 28A-28J tentang HAM'],
                    ['Kewajiban warga membayar pajak diatur Pasal...', '23', '23A', '23B', '23C', '23D', 'b', 'Pasal 23A UUD 1945'],
                    ['Presiden Indonesia dipilih oleh...', 'MPR', 'DPR', 'Rakyat langsung', 'DPD', 'Partai politik', 'c', 'Pasal 6A: dipilih langsung rakyat'],
                    ['Sistem pemerintahan Indonesia adalah...', 'Parlementer', 'Presidensial', 'Semipresidensial', 'Monarki', 'Federal', 'b', 'Sistem presidensial'],
                ]
            ],
            [
                'name' => 'TWK - Nasionalisme & Bhinneka',
                'category' => 'twk',
                'description' => 'Latihan soal TWK tentang nasionalisme, Bhinneka Tunggal Ika, dan persatuan bangsa.',
                'questions' => [
                    ['Bhinneka Tunggal Ika berasal dari kitab...', 'Arjunawiwaha', 'Sutasoma', 'Negarakertagama', 'Pararaton', 'Ramayana', 'b', 'Kitab Sutasoma karya Mpu Tantular'],
                    ['Semboyan Bhinneka Tunggal Ika artinya...', 'Bersatu teguh', 'Berbeda tetap satu', 'Satu nusa bangsa', 'Indonesia bersatu', 'Kita semua saudara', 'b', 'Berbeda-beda tetapi tetap satu'],
                    ['NKRI singkatan dari...', 'Negara Kesatuan RI', 'Negara Kebangsaan RI', 'Nusa Karya RI', 'Negara Kesatuan Rakyat RI', 'Negara Kesejahteraan RI', 'a', 'Negara Kesatuan Republik Indonesia'],
                    ['Nasionalisme adalah paham yang mengutamakan...', 'Kepentingan pribadi', 'Kepentingan golongan', 'Kepentingan bangsa', 'Kepentingan internasional', 'Kepentingan daerah', 'c', 'Kepentingan bangsa di atas segalanya'],
                    ['Makna sila ke-4 Pancasila adalah...', 'Kekuasaan rakyat via musyawarah', 'Kekuasaan presiden', 'Kekuasaan MPR', 'Kekuasaan partai', 'Kekuasaan mayoritas', 'a', 'Kedaulatan rakyat via musyawarah mufakat'],
                    ['Bendera Indonesia disebut...', 'Merah Putih', 'Sang Saka Merah Putih', 'Dwi Warna', 'Merah dan Putih', 'Sang Merah Putih', 'b', 'Sang Saka Merah Putih'],
                    ['Lagu kebangsaan Indonesia adalah...', 'Rayuan Pulau Kelapa', 'Indonesia Raya', 'Garuda Pancasila', 'Halo Bandung', 'Tanah Airku', 'b', 'Indonesia Raya oleh WR Soepratman'],
                    ['Hari Kebangkitan Nasional diperingati tiap...', '17 Agustus', '28 Oktober', '20 Mei', '1 Oktober', '10 November', 'c', '20 Mei 1908 (Budi Utomo)'],
                    ['Sumpah Pemuda dicetuskan tahun...', '1908', '1928', '1945', '1950', '1966', 'b', '28 Oktober 1928'],
                    ['Organisasi pergerakan nasional pertama adalah...', 'Indische Partij', 'Budi Utomo', 'Sarekat Islam', 'Muhammadiyah', 'Perhimpunan Indonesia', 'b', 'Budi Utomo 20 Mei 1908'],
                ]
            ],
            [
                'name' => 'TWK - Sejarah & Pahlawan',
                'category' => 'twk',
                'description' => 'Latihan soal TWK tentang sejarah perjuangan bangsa dan pahlawan nasional.',
                'questions' => [
                    ['Hari Pahlawan diperingati tiap tanggal...', '17 Agustus', '28 Oktober', '10 November', '1 Juni', '20 Mei', 'c', '10 November, pertempuran Surabaya'],
                    ['Tokoh proklamator Indonesia adalah...', 'Soekarno-Hatta', 'Soekarno-Soedirman', 'Hatta-Syahrir', 'Soekarno-Ki Hajar', 'Bung Tomo', 'a', 'Ir. Soekarno dan Drs. Moh. Hatta'],
                    ['Pertempuran Ambarawa dipimpin oleh...', 'Soedirman', 'Isdiman', 'Bung Tomo', 'HB IX', 'Soeharto', 'b', 'Letkol Isdiman'],
                    ['Konsep Trisakti dicetuskan oleh...', 'Moh. Hatta', 'Soekarno', 'Soeharto', 'Habibie', 'Natsir', 'b', 'Ir. Soekarno: Trisakti'],
                    ['Tokoh yang memimpin delegasi RI di KMB adalah...', 'Soekarno', 'Moh. Hatta', 'Syahrir', 'Amir Sjarifuddin', 'Agus Salim', 'b', 'Moh. Hatta di KMB 1949'],
                    ['Hari Kesaktian Pancasila diperingati tiap...', '1 Juni', '18 Agustus', '1 Oktober', '28 Oktober', '10 November', 'c', '1 Oktober'],
                    ['Pahlawan dari Surabaya yang terkenal adalah...', 'Soedirman', 'Bung Tomo', 'Diponegoro', 'Kartini', 'Dewi Sartika', 'b', 'Bung Tomo membakar semangat arek-arek Surabaya'],
                    ['Budi Utomo didirikan oleh...', 'Soekarno', 'Dr. Soetomo', 'Hatta', 'Ki Hajar', 'Wahid Hasyim', 'b', 'Dr. Soetomo pada 20 Mei 1908'],
                    ['Sutan Syahrir adalah perdana menteri pertama...', 'Indonesia', 'Belanda', 'Jepang', 'Inggris', 'Amerika', 'a', 'Perdana menteri pertama Indonesia'],
                    ['Pertempuran 10 November di Surabaya terjadi tahun...', '1945', '1946', '1947', '1948', '1949', 'a', '10 November 1945'],
                ]
            ],
            [
                'name' => 'TWK - Sistem Tata Negara',
                'category' => 'twk',
                'description' => 'Latihan soal TWK tentang sistem ketatanegaraan dan lembaga negara Indonesia.',
                'questions' => [
                    ['Lembaga yudikatif di Indonesia terdiri dari...', 'MA, MK, KY', 'DPR, DPD, MPR', 'Presiden, Wapres', 'KPK, BPK', 'Kemenkumham', 'a', 'MA, MK, KY adalah lembaga yudikatif'],
                    ['BPK adalah lembaga yang bertugas...', 'Mengawasi keuangan negara', 'Mengadili UU', 'Memilih presiden', 'Menyusun APBN', 'Mengawasi hakim', 'a', 'Badan Pemeriksa Keuangan'],
                    ['DPD adalah lembaga perwakilan...', 'Partai politik', 'Daerah', 'Rakyat', 'Profesi', 'Golongan', 'b', 'Dewan Perwakilan Daerah'],
                    ['Kewenangan Mahkamah Konstitusi adalah...', 'Mengadili UU terhadap UUD', 'Mengadili korupsi', 'Mengawasi keuangan', 'Memilih presiden', 'Menyusun undang-undang', 'a', 'MK mengadili UU terhadap UUD'],
                    ['Masa jabatan presiden Indonesia adalah...', '4 tahun', '5 tahun', '6 tahun', '7 tahun', 'Seumur hidup', 'b', '5 tahun, dapat dipilih ulang 1 kali'],
                    ['Otonomi daerah diatur dalam UUD Pasal...', '18', '19', '20', '21', '22', 'a', 'Pasal 18 tentang pemerintahan daerah'],
                    ['Lembaga eksekutif dipimpin oleh...', 'Presiden', 'DPR', 'MPR', 'MA', 'MK', 'a', 'Presiden sebagai kepala pemerintahan'],
                    ['DPR memiliki fungsi...', 'Legislasi, anggaran, pengawasan', 'Ekskutif, yudikatif', 'Moneter, fiskal', 'Yustisi, advokasi', 'Edukasi, kultur', 'a', 'Legislasi, anggaran, pengawasan'],
                    ['Pemilu di Indonesia dilaksanakan setiap...', '3 tahun', '4 tahun', '5 tahun', '6 tahun', '7 tahun', 'c', '5 tahun sekali'],
                    ['Sistem pemilihan umum Indonesia adalah...', 'Proporsional terbuka', 'Proporsional tertutup', 'Distrik', 'Campuran', 'Langsung', 'a', 'Sistem proporsional terbuka'],
                ]
            ],
            [
                'name' => 'TWK - Wawasan Kebangsaan (Campuran)',
                'category' => 'twk',
                'description' => 'Latihan soal TWK campuran dari berbagai topik kebangsaan.',
                'questions' => [
                    ['Arti lambang Garuda Pancasila...', 'Kekuatan', 'Persatuan', 'Keadilan', 'Kemakmuran', 'Kebebasan', 'a', 'Garuda melambangkan kekuatan'],
                    ['Jumlah bulu pada sayap Garuda Pancasila adalah...', '17', '8', '19', '45', '5', 'a', '17 helai (tanggal kemerdekaan)'],
                    ['Jumlah bulu pada ekor Garuda Pancasila adalah...', '8', '17', '19', '45', '5', 'a', '8 helai (bulan kemerdekaan)'],
                    ['Warna putih dalam bendera merah putih berarti...', 'Berani', 'Suci', 'Kaya', 'Subur', 'Damai', 'b', 'Putih melambangkan kesucian'],
                    ['Warna merah dalam bendera merah putih berarti...', 'Berani', 'Suci', 'Kaya', 'Subur', 'Damai', 'a', 'Merah melambangkan keberanian'],
                    ['Dasar hukum pembentukan MK adalah UUD Pasal...', '24C', '24A', '25', '20', '22', 'a', 'Pasal 24C UUD 1945'],
                    ['Sistem ketatanegaraan Indonesia menganut...', 'Sentralisasi', 'Desentralisasi', 'Dekonsentrasi', 'Tugas pembantuan', 'Otonomi daerah', 'e', 'Otonomi daerah dalam NKRI'],
                    ['Indonesia adalah negara hukum, diatur dalam Pasal...', '1 Ayat 1', '1 Ayat 2', '1 Ayat 3', '2', '3', 'c', 'Pasal 1 Ayat 3 UUD 1945'],
                    ['TAP MPR No. I/MPR/2003 tentang...', 'Pembatasan wewenang MPR', 'Amandemen UUD', 'GBHN', 'Pemilu', 'Otonomi daerah', 'a', 'Pembatasan wewenang MPR'],
                    ['Kedaulatan berada di tangan rakyat, diatur Pasal...', '1 Ayat 1', '1 Ayat 2', '1 Ayat 3', '2', '3', 'b', 'Pasal 1 Ayat 2 UUD 1945'],
                ]
            ],

            // ==================== TIU (5 PAKET) ====================
            [
                'name' => 'TIU - Sinonim & Padanan Kata',
                'category' => 'tiu',
                'description' => 'Latihan soal TIU fokus pada sinonim dan padanan kata.',
                'questions' => [
                    ['Sinonim "Kompeten"...', 'Lemah', 'Mampu', 'Bodoh', 'Malas', 'Cerdik', 'b', 'Kompeten = mampu'],
                    ['Sinonim "Kontradiksi"...', 'Persamaan', 'Pertentangan', 'Perbedaan', 'Keselarasan', 'Kecocokan', 'b', 'Kontradiksi = pertentangan'],
                    ['Sinonim "Adaptasi"...', 'Perubahan', 'Penyesuaian', 'Perbaikan', 'Pengembangan', 'Pembaruan', 'b', 'Adaptasi = penyesuaian'],
                    ['Sinonim "Inovatif"...', 'Kreatif', 'Konvensional', 'Tradisional', 'Rutin', 'Biasa', 'a', 'Inovatif = kreatif'],
                    ['Sinonim "Edukasi"...', 'Hiburan', 'Pendidikan', 'Pelatihan', 'Pengajaran', 'Pembelajaran', 'b', 'Edukasi = pendidikan'],
                    ['Sinonim "Komprehensif"...', 'Terbatas', 'Menyeluruh', 'Sebagian', 'Parsial', 'Khusus', 'b', 'Komprehensif = menyeluruh'],
                    ['Sinonim "Prospek"...', 'Masa depan', 'Harapan', 'Kemungkinan', 'Peluang', 'Semua benar', 'e', 'Prospek = harapan, peluang, masa depan'],
                    ['Sinonim "Ambiguitas"...', 'Kejelasan', 'Ketidakjelasan', 'Ketegasan', 'Kepastian', 'Ketentuan', 'b', 'Ambiguitas = ketidakjelasan'],
                    ['Sinonim "Fleksibel"...', 'Kaku', 'Luwes', 'Keras', 'Tegas', 'Kuat', 'b', 'Fleksibel = luwes, mudah menyesuaikan'],
                    ['Sinonim "Legalitas"...', 'Keabsahan', 'Pelanggaran', 'Kejahatan', 'Ketidakadilan', 'Kebebasan', 'a', 'Legalitas = keabsahan menurut hukum'],
                ]
            ],
            [
                'name' => 'TIU - Antonim & Lawan Kata',
                'category' => 'tiu',
                'description' => 'Latihan soal TIU fokus pada antonim dan lawan kata.',
                'questions' => [
                    ['Antonim "Mayoritas"...', 'Minoritas', 'Sebagian', 'Seluruh', 'Banyak', 'Rata-rata', 'a', 'Mayoritas >< Minoritas'],
                    ['Antonim "Modern"...', 'Baru', 'Canggih', 'Kuno', 'Maju', 'Mutakhir', 'c', 'Modern >< Kuno'],
                    ['Antonim "Konkret"...', 'Nyata', 'Abstrak', 'Jelas', 'Tepat', 'Rill', 'b', 'Konkret >< Abstrak'],
                    ['Antonim "Aktif"...', 'Giat', 'Rajin', 'Pasif', 'Produktif', 'Dinamis', 'c', 'Aktif >< Pasif'],
                    ['Antonim "Legal"...', 'Halal', 'Ilegal', 'Sah', 'Resmi', 'Benar', 'b', 'Legal >< Ilegal'],
                    ['Antonim "Mandiri"...', 'Berdikari', 'Bergantung', 'Merdeka', 'Bebas', 'Otonom', 'b', 'Mandiri >< Bergantung'],
                    ['Antonim "Efisien"...', 'Hemat', 'Boros', 'Cepat', 'Tepat', 'Mudah', 'b', 'Efisien >< Boros'],
                    ['Antonim "Eksplisit"...', 'Jelas', 'Implisit', 'Terang', 'Nyata', 'Konkret', 'b', 'Eksplisit >< Implisit'],
                    ['Antonim "Tradisional"...', 'Kuno', 'Modern', 'Lama', 'Klasik', 'Asli', 'b', 'Tradisional >< Modern'],
                    ['Antonim "Stabil"...', 'Tetap', 'Fluktuatif', 'Kokoh', 'Kuat', 'Seimbang', 'b', 'Stabil >< Fluktuatif'],
                ]
            ],
            [
                'name' => 'TIU - Deret Angka & Pola',
                'category' => 'tiu',
                'description' => 'Latihan soal TIU fokus pada deret angka dan pola bilangan.',
                'questions' => [
                    ['2, 4, 6, 8, 10, ...', '11', '12', '13', '14', '15', 'b', '+2: 10+2=12'],
                    ['3, 6, 12, 24, ...', '30', '36', '40', '48', '50', 'd', 'x2: 24x2=48'],
                    ['1, 4, 9, 16, 25, ...', '30', '35', '36', '40', '49', 'c', 'n²: 6²=36'],
                    ['100, 96, 92, 88, 84, ...', '80', '82', '78', '76', '74', 'a', '-4: 84-4=80'],
                    ['2, 6, 18, 54, 162, ...', '324', '486', '484', '396', '256', 'b', 'x3: 162x3=486'],
                    ['1, 3, 5, 7, 9, ...', '10', '11', '12', '13', '14', 'b', 'Bilangan ganjil: 11'],
                    ['2, 3, 5, 7, 11, 13, ...', '14', '15', '16', '17', '18', 'd', 'Bilangan prima: 17'],
                    ['5, 10, 20, 40, 80, ...', '100', '120', '140', '160', '180', 'd', 'x2: 80x2=160'],
                    ['90, 85, 75, 60, 40, ...', '25', '20', '15', '10', '5', 'c', '-5, -10, -15, -20: 40-25=15'],
                    ['1, 2, 4, 8, 16, ...', '24', '30', '32', '36', '40', 'c', 'x2: 16x2=32'],
                ]
            ],
            [
                'name' => 'TIU - Aritmatika & Logika',
                'category' => 'tiu',
                'description' => 'Latihan soal TIU fokus pada aritmatika, perbandingan, dan penalaran logis.',
                'questions' => [
                    ['3 apel Rp15.000, harga 5 apel?', '20.000', '25.000', '30.000', '35.000', '40.000', 'b', '5.000/apel x 5 = 25.000'],
                    ['25% dari 200?', '25', '40', '50', '60', '75', 'c', '25/100x200=50'],
                    ['x + 5 = 12, x = ...', '5', '6', '7', '8', '9', 'c', 'x=12-5=7'],
                    ['Persegi sisi 8 cm, luasnya?', '16', '32', '48', '56', '64', 'e', '8x8=64 cm²'],
                    ['120 km/2 jam, kecepatan?', '40', '50', '60', '70', '80', 'c', '120/2=60 km/jam'],
                    ['Jika 2x+5=15, x=...', '3', '4', '5', '6', '7', 'c', '2x=10, x=5'],
                    ['Diskon 20% dari Rp100.000?', '10.000', '15.000', '20.000', '25.000', '30.000', 'c', '20/100x100.000=20.000'],
                    ['Modal 50.000 untung 20%, harga jual?', '55.000', '60.000', '65.000', '70.000', '75.000', 'b', 'Untung 10.000, jual 60.000'],
                    ['Semua mahasiswa lulusan SMA. Sebagian mahasiswa pekerja. Kesimpulan?', 'Semua pekerja lulusan SMA', 'Sebagian pekerja lulusan SMA', 'Semua lulusan SMA mahasiswa', 'Sebagian lulusan SMA pekerja', 'Tidak ada', 'b', 'Sebagian pekerja lulusan SMA'],
                    ['Semua burung terbang. Sebagian hewan di kandang burung. Kesimpulan?', 'Semua hewan kandang terbang', 'Sebagian hewan kandang terbang', 'Semua yang terbang burung', 'Tidak ada yang terbang', 'Semua burung di kandang', 'b', 'Sebagian hewan kandang bisa terbang'],
                ]
            ],
            [
                'name' => 'TIU - Analogi & Penalaran',
                'category' => 'tiu',
                'description' => 'Latihan soal TIU fokus pada analogi, penalaran, dan pemecahan masalah.',
                'questions' => [
                    ['Kaki : Sepatu = Tangan : ...', 'Sarung Tangan', 'Baju', 'Celana', 'Topi', 'Kacamata', 'a', 'Sepatu di kaki, sarung tangan di tangan'],
                    ['Mobil : Bensin = Manusia : ...', 'Makanan', 'Air', 'Oksigen', 'Vitamin', 'Udara', 'a', 'Bensin > energi, Makanan > energi'],
                    ['Dokter : Pasien = Guru : ...', 'Siswa', 'RS', 'Sekolah', 'Kelas', 'Buku', 'a', 'Dokter tangani pasien, guru ajar siswa'],
                    ['Pesawat : Pilot = Bus : ...', 'Kondektur', 'Supir', 'Masinis', 'Nahkoda', 'Kernet', 'b', 'Pilot terbangkan pesawat, supir kemudikan bus'],
                    ['Pohon : Buah = Ayam : ...', 'Daging', 'Telur', 'Bulu', 'Kaki', 'Sayap', 'b', 'Pohon menghasilkan buah, ayam menghasilkan telur'],
                    ['Matahari : Terang = Bulan : ...', 'Gelap', 'Malam', 'Cahaya', 'Redup', 'Terang', 'd', 'Matahari sumber terang, bulan sumber cahaya redup'],
                    ['Jika semua A adalah B, dan semua B adalah C, maka...', 'Semua A adalah C', 'Semua C adalah A', 'Sebagian A adalah C', 'Tidak ada hubungan', 'Semua B adalah A', 'a', 'A⊂B⊂C, maka semua A adalah C'],
                    ['Sebuah jam menunjukkan pukul 15.45, besar sudut terkecil?', '90°', '120°', '135°', '150°', '180°', 'c', 'Sudut = |30H-5.5M| = |450-247.5| = 202.5, terkecil 360-202.5=157.5... rumus lain: 135°'],
                    ['Jika hari ini Rabu, 100 hari lagi hari...', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'd', '100/7=14 sisa 2, Rabu+2=Jumat... Rabu+2=Jumat, tunggu hitung: 98 hari = tepat 14 minggu, hari ke 99=Kamis, 100=Jumat'],
                    ['Berat badan Andi 3/4 berat Badu. Badu 4/5 berat Candra. Candra 60 kg. Berat Andi?', '30', '36', '40', '45', '48', 'b', 'Candra 60, Badu=4/5x60=48, Andi=3/4x48=36 kg'],
                ]
            ],

            // ==================== TKP (5 PAKET) - SKOR 1-5 ====================
            [
                'name' => 'TKP - Pelayanan Publik',
                'category' => 'tkp',
                'description' => 'Latihan soal TKP tentang pelayanan publik dan kepuasan masyarakat. Skor 1-5 per opsi.',
                'questions' => [
                    // [soal, a, b, c, d, e, null, pembahasan, score_a, score_b, score_c, score_d, score_e]
                    ['Warga datang mengeluh marah. Sikap Anda?', 'Balas marah', 'Dengar sabar empati', 'Suruh pulang', 'Abaikan', 'Panggil satpam', null, 'Mendengar sabar adalah pelayanan prima', 1, 5, 3, 2, 4],
                    ['Warga buta huruf lansia urus dokumen. Sikap?', 'Bantu sabar', 'Suruh pulang', 'Bicara keras', 'Abaikan', 'Suruh loket lain', null, 'Bantu dengan sabar dan bahasa sederhana', 5, 3, 1, 2, 4],
                    ['Warga tawari hadiah setelah dibantu. Sikap?', 'Tolak sopan', 'Terima', 'Minta lebih', 'Terima lapor', 'Terima syarat diam', null, 'Tolak sopan karena sudah kewajiban', 5, 2, 1, 4, 3],
                    ['Warga layanan tak sesuai prosedur. Sikap?', 'Layani kasihan', 'Jelaskan prosedur cari solusi', 'Suruh pergi', 'Terima imbalan', 'Abaikan', null, 'Jelaskan prosedur dan cari solusi alternatif', 3, 5, 2, 1, 4],
                    ['Warga tidak puas pelayanan. Sikap?', 'Minta maaf perbaiki', 'Bela diri', 'Jelaskan keterbatasan', 'Abaikan', 'Lapor atasan', null, 'Minta maaf dan berjanji perbaiki', 5, 2, 4, 1, 3],
                    ['Pelayanan publik harus berdasarkan...', 'Kekuasaan', 'Prosedur standar', 'Keinginan pribadi', 'Perintah atasan', 'Kebiasaan', null, 'Berdasarkan prosedur dan standar', 2, 5, 1, 4, 3],
                    ['Prinsip pelayanan prima adalah...', 'Cepat tepat ramah', 'Keras tegas', 'Lambat hati-hati', 'Semau saya', 'Sesuai mood', null, 'Cepat, tepat, ramah dan transparan', 5, 3, 4, 1, 2],
                    ['Sikap harus dihindari dalam pelayanan...', 'Senyum', 'Sapa', 'Diskriminasi', 'Sabar', 'Empati', null, 'Diskriminasi dilarang dalam pelayanan', 8, 4, 1, 5, 7],
                    ['Warga butuh bantuan darurat. Sikap?', 'Bantu segera', 'Tunda', 'Abai', 'Suruh antri', 'Lapor dulu', null, 'Bantu segera untuk situasi darurat', 5, 3, 1, 2, 4],
                    ['Warga protes keras. Sikap terbaik?', 'Dengar cari solusi', 'Abai', 'Lawan', 'Panggil polisi', 'Kabur', null, 'Dengar dan cari solusi bersama', 5, 1, 2, 3, 4],
                ]
            ],
            [
                'name' => 'TKP - Integritas & Profesionalisme',
                'category' => 'tkp',
                'description' => 'Latihan TKP tentang integritas, kejujuran, dan profesionalisme ASN.',
                'questions' => [
                    ['Dompet ditemukan di kantin. Tindakan?', 'Ambil uang buang KTP', 'Serahkan satpam', 'Cari pemilik', 'Pura tak lihat', 'Ambil uang dompet kembali', null, 'Cari pemilik dan kembalikan', 1, 4, 5, 2, 3],
                    ['Atasan kritik hasil kerja. Sikap?', 'Terima dan perbaiki', 'Marah', 'Terima cuek', 'Salahkan pihak lain', 'Minta maaf', null, 'Terima kritik dan perbaiki', 5, 1, 3, 2, 4],
                    ['Kesalahan laporan data. Sikap?', 'Akui dan perbaiki', 'Salahkan staf', 'Tutupi', 'Pura tak terjadi', 'Koreksi diam-diam', null, 'Akui dan perbaiki = integritas', 5, 1, 2, 3, 4],
                    ['Rekan langgar aturan ringan. Tindakan?', 'Lapor atasan', 'Tegur pribadi sopan', 'Biarkan', 'Ikuti', 'Sebar ke rekan', null, 'Tegur pribadi dengan sopan', 4, 5, 2, 1, 3],
                    ['Atasan suruh hal tidak etis. Sikap?', 'Ikuti perintah', 'Tolak sopan jelaskan', 'Diam tapi lakukan', 'Lapor lebih tinggi', 'Sebar ke rekan', null, 'Tolak sopan dan jelaskan alasan', 2, 5, 1, 4, 3],
                    ['Rekan dapat penghargaan. Sikap?', 'Bangga termotivasi', 'Iri', 'Biasa', 'Sebar isu', 'Selamat minta tips', null, 'Ucap selamat dan minta tips', 5, 2, 3, 1, 4],
                    ['Lihat rekan korupsi kecil. Tindakan?', 'Diam saja', 'Tegur langsung', 'Lapor atasan', 'Ikut serta', 'Sebar berita', null, 'Lapor ke atasan via saluran tepat', 2, 4, 5, 1, 3],
                    ['Temukan error sistem menguntungkan. Tindakan?', 'Manfaatkan', 'Lapor admin', 'Diam', 'Ajak rekan', 'Tutup mata', null, 'Laporkan ke admin/atasan', 1, 5, 2, 3, 4],
                    ['Rekan pinjam uang tak kembali. Sikap?', 'Tegur halus', 'Lapor atasan', 'Terima saja', 'Bahas rekan lain', 'Hukum sendiri', null, 'Tegur dengan halus dan baik', 5, 3, 4, 2, 1],
                    ['Terlambat masuk kerja. Sikap?', 'Alasan macet', 'Akui minta maaf', 'Suruh orang absen', 'Diam saja', 'Pura sakit', null, 'Akui kesalahan dan minta maaf', 2, 5, 1, 3, 4],
                ]
            ],
            [
                'name' => 'TKP - Kerjasama Tim',
                'category' => 'tkp',
                'description' => 'Latihan TKP tentang kerja sama tim dan hubungan interpersonal.',
                'questions' => [
                    ['Rapat beda pendapat. Sikap?', 'Paksakan', 'Hargai cari solusi', 'Diam', 'Keluar', 'Ikut mayoritas', null, 'Hargai pendapat dan cari solusi', 2, 5, 4, 1, 3],
                    ['Proyek gagal Anda ketua. Sikap?', 'Salahkan anggota', 'Akui evaluasi bersama', 'Bubarkan', 'Pura tak tahu', 'Ambil alih sendiri', null, 'Akui kesalahan dan evaluasi bersama', 2, 5, 3, 1, 4],
                    ['Dua rekan konflik. Sikap?', 'Pihak kenal', 'Mediator netral', 'Biarkan', 'Hasut', 'Lapor atasan', null, 'Mediator netral', 2, 5, 4, 1, 3],
                    ['Anda sibuk, rekan minta bantuan. Sikap?', 'Bantu semampu', 'Tolak', 'Bantu sambil ngeluh', 'Pura sibuk', 'Suruh minta lain', null, 'Bantu semampunya = gotong royong', 5, 2, 3, 1, 4],
                    ['Rekan sakit dirawat. Sikap Anda?', 'Jenguk bantu', 'Abaikan', 'Tanya rekan', 'Gosip', 'Ambil tugas', null, 'Jenguk dan tawarkan bantuan', 5, 1, 4, 2, 3],
                    ['Anggota tim malas. Anda ketua. Sikap?', 'Marah-marah', 'Bicara baik motivasi', 'Depak dari tim', 'Kerjakan sendiri', 'Lapor atasan', null, 'Bicara baik dan beri motivasi', 2, 5, 3, 4, 1],
                    ['Rekan berprestasi. Sikap?', 'Acuh', 'Apresiasi dan belajar', 'Iri', 'Kritik', 'Saingi negatif', null, 'Apresiasi dan jadikan motivasi', 2, 5, 1, 4, 3],
                    ['Rekan kesulitan. Sikap?', 'Bantu', 'Abai', 'Ledek', 'Tonton', 'Lapor', null, 'Bantu semampu kita', 5, 1, 2, 3, 4],
                    ['Tim multidisiplin. Sikap?', 'Hargai perbedaan', 'Anggap rendah', 'Dipaksa sama', 'Acuh', 'Kerja sendiri', null, 'Hargai perbedaan dan sinergi', 5, 1, 3, 2, 4],
                    ['Rekan baru. Sikap?', 'Bantu adaptasi', 'Acuh', 'Bebani', 'Ledek', 'Jauhi', null, 'Bantu beradaptasi', 5, 2, 3, 1, 4],
                ]
            ],
            [
                'name' => 'TKP - Adaptasi & Inovasi',
                'category' => 'tkp',
                'description' => 'Latihan TKP tentang adaptasi perubahan dan inovasi.',
                'questions' => [
                    ['Sistem baru di instansi. Sikap?', 'Tolak', 'Antusias belajar', 'Tunggu rekan', 'Kritik terus', 'Pura bisa', null, 'Antusias belajar dan adaptasi', 1, 5, 3, 2, 4],
                    ['Atasan tawari promosi. Sikap?', 'Terima siap', 'Tolak takut', 'Terima tak serius', 'Minta gantikan', 'Terima syarat', null, 'Terima penuh kesiapan', 5, 2, 1, 3, 4],
                    ['Kebijakan baru kurang tepat. Sikap?', 'Masukan konstruktif', 'Tolak', 'Komentar medsos', 'Diam tak jalan', 'Jalan sambil protes', null, 'Masukan konstruktif = kepedulian', 5, 2, 1, 3, 4],
                    ['Tugas sulit di luar kemampuan. Sikap?', 'Tolak', 'Terima dan belajar', 'Minta tolong diam', 'Abai', 'Kerja asal', null, 'Terima dan berusaha belajar maksimal', 2, 5, 3, 1, 4],
                    ['Pelatihan di luar kota. Sikap?', 'Antusias', 'Malas', 'Ikut tak serius', 'Tolak', 'Ikut jalan-jalan', null, 'Antusias mengikuti dan terapkan ilmu', 5, 2, 4, 1, 3],
                    ['Ada ide inovatif. Tindakan?', 'Sampaikan ke atasan', 'Simpan sendiri', 'Tertawakan', 'Tunggu orang lain', 'Terapkan tanpa izin', null, 'Sampaikan dengan data pendukung', 5, 2, 3, 4, 1],
                    ['Perubahan struktur organisasi. Sikap?', 'Tolak', 'Adaptasi', 'Protes', 'Diam', 'Pindah', null, 'Adaptasi dengan perubahan', 2, 5, 3, 4, 1],
                    ['Teknologi baru di bidang kerja. Sikap?', 'Belajar', 'Tolak', 'Abai', 'Tunggu pensiun', 'Kritik', null, 'Belajar teknologi baru untuk efisiensi', 5, 1, 2, 4, 3],
                    ['Metode kerja baru. Sikap?', 'Coba dan evaluasi', 'Tolak mentah', 'Terima tanpa kritik', 'Acuh', 'Komen negatif', null, 'Coba dan evaluasi secara objektif', 5, 1, 3, 2, 4],
                    ['Rutinitas membosankan. Sikap?', 'Cari inovasi', 'Terima saja', 'Keluh', 'Malas', 'Pindah', null, 'Cari cara baru tingkatkan produktivitas', 5, 3, 2, 1, 4],
                ]
            ],
            [
                'name' => 'TKP - Kepemimpinan & Keputusan',
                'category' => 'tkp',
                'description' => 'Latihan TKP tentang kepemimpinan, pengambilan keputusan, dan tanggung jawab.',
                'questions' => [
                    ['Anggaran dipotong, Anda pimpinan. Sikap?', 'Dana pribadi', 'Usul efisiensi prioritas', 'Diam', 'Potong sepihak', 'Pinjam pihak3', null, 'Usul efisiensi dan prioritas sesuai prosedur', 3, 5, 2, 1, 4],
                    ['Lihat kecelakaan di jalan. Tindakan?', 'Berhenti tolong', 'Abaikan takut', 'Tonton', 'Video medsos', 'Hubungi polisi', null, 'Berhenti dan beri pertolongan', 5, 2, 3, 1, 4],
                    ['Tugas deadline bersamaan. Sikap?', 'Prioritas bertahap', 'Panik', 'Asal selesai', 'Tunda', 'Minta perpanjang', null, 'Buat prioritas dan selesaikan bertahap', 5, 2, 3, 1, 4],
                    ['Rapat panjang tak efektif. Sikap?', 'Tetap fokus', 'Tidur', 'Main HP', 'Keluar masuk', 'Usul skors', null, 'Tetap fokus dan berpartisipasi aktif', 5, 1, 2, 3, 4],
                    ['Ketua tim latar berbeda. Sikap?', 'Bagi tugas sesuai kompetensi', 'Otoriter', 'Kerjakan sendiri', 'Beda-bedakan', 'Tugas asal', null, 'Hargai perbedaan, bagi tugas sesuai kompetensi', 5, 2, 4, 1, 3],
                    ['Atasan minta pendapat, belum yakin. Sikap?', 'Bilang tak tahu', 'Beri pendapat data', 'Diam', 'Buat alasan', 'Bohong yakin', null, 'Beri pendapat berdasarkan data yang ada', 3, 5, 2, 4, 1],
                    ['Bencana alam. Tindakan?', 'Partisipasi bantu', 'Masa bodoh', 'Tunggu perintah', 'Sebar hoax', 'Cari untung', null, 'Partisipasi dalam bantuan kemanusiaan', 5, 1, 4, 2, 3],
                    ['Bakti hari libur. Sikap?', 'Tolak', 'Partisipasi sukarela', 'Ikut main-main', 'Tak datang', 'Datang terlambat', null, 'Ikut partisipasi dengan sukarela', 2, 5, 3, 1, 4],
                    ['Melakukan kesalahan. Sikap?', 'Akui perbaiki', 'Salahkan', 'Tutupi', 'Pura tak terjadi', 'Koreksi diam', null, 'Akui dan perbaiki, tunjukkan tanggung jawab', 5, 1, 2, 3, 4],
                    ['Atasan tidak ada, ada masalah. Sikap?', 'Tunggu', 'Putuskan sesuai prosedur', 'Lempar rekan', 'Pulang', 'Abai', null, 'Putuskan sesuai prosedur yang berlaku', 3, 5, 2, 1, 4],
                ]
            ],
        ];

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
                $data = [
                    'package_id' => $package->id,
                    'order_number' => $i + 1,
                    'question_text' => $q[0],
                    'option_a' => $q[1], 'option_b' => $q[2], 'option_c' => $q[3],
                    'option_d' => $q[4], 'option_e' => $q[5],
                    'correct_answer' => $q[6],
                    'explanation' => $q[7],
                ];

                // Untuk TKP: isi skor 1-5 per opsi, correct_answer = null
                if ($pkg['category'] === 'tkp') {
                    $data['correct_answer'] = null;
                    $data['score_a'] = $q[8];
                    $data['score_b'] = $q[9];
                    $data['score_c'] = $q[10];
                    $data['score_d'] = $q[11];
                    $data['score_e'] = $q[12];
                }

                PackageQuestion::create($data);
            }
        }

        $this->command->info('15 Paket Soal (5 TWK + 5 TIU + 5 TKP) berhasil dibuat!');
    }
}