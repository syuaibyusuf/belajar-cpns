<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    // Halaman utama
    public function index()
    {
        return view('home');
    }
    
    // Halaman materi
    public function materi($category)
    {
        $materi = [];
        
        if ($category == 'twk') {
            $materi = [
                'title' => 'Tes Wawasan Kebangsaan (TWK)',
                'content' => "📚 MATERI TWK (Tes Wawasan Kebangsaan)\n\n".
                    "1. PANCASILA\n".
                    "   • Sila 1: Ketuhanan Yang Maha Esa\n".
                    "   • Sila 2: Kemanusiaan yang adil dan beradab\n".
                    "   • Sila 3: Persatuan Indonesia\n".
                    "   • Sila 4: Kerakyatan yang dipimpin oleh hikmat kebijaksanaan dalam permusyawaratan/perwakilan\n".
                    "   • Sila 5: Keadilan sosial bagi seluruh rakyat Indonesia\n\n".
                    "2. UUD 1945\n".
                    "   • Disahkan 18 Agustus 1945\n".
                    "   • Terdiri dari Pembukaan dan pasal-pasal\n\n".
                    "3. BHINEKA TUNGGAL IKA\n".
                    "   • Berbeda-beda tetapi tetap satu\n".
                    "   • Semboyan negara Indonesia\n\n".
                    "4. NKRI\n".
                    "   • Bentuk negara kesatuan\n".
                    "   • Sistem pemerintahan presidensial"
            ];
        } elseif ($category == 'tiu') {
            $materi = [
                'title' => 'Tes Intelegensi Umum (TIU)',
                'content' => "📚 MATERI TIU (Tes Intelegensi Umum)\n\n".
                    "1. SINONIM (Persamaan Kata)\n".
                    "   • Contoh: Kompeten = Mampu\n".
                    "   • Contoh: Kontradiksi = Pertentangan\n\n".
                    "2. ANTONIM (Lawan Kata)\n".
                    "   • Contoh: Mayoritas = Minoritas\n".
                    "   • Contoh: Modern = Kuno\n\n".
                    "3. ANALOGI\n".
                    "   • Mencari hubungan antar kata\n".
                    "   • Contoh: Kaki : Sepatu = Tangan : Sarung Tangan\n\n".
                    "4. DERET ANGKA\n".
                    "   • 2, 4, 6, 8, ... (ditambah 2)\n".
                    "   • 3, 6, 12, 24, ... (dikali 2)\n\n".
                    "5. LOGIKA ARITMATIKA\n".
                    "   • Soal cerita matematika\n".
                    "   • Perbandingan, persentase, jarak, waktu"
            ];
        } else {
            $materi = [
                'title' => 'Tes Karakteristik Pribadi (TKP)',
                'content' => "📚 MATERI TKP (Tes Karakteristik Pribadi)\n\n".
                    "1. INTEGRITAS DIRI\n".
                    "   • Jujur, konsisten antara ucapan dan tindakan\n".
                    "   • Tidak korupsi, tidak menyalahgunakan wewenang\n\n".
                    "2. SEMANGAT BERPRESTASI\n".
                    "   • Pantang menyerah\n".
                    "   • Selalu ingin belajar dan berkembang\n\n".
                    "3. ORIENTASI PELAYANAN\n".
                    "   • Ramah dan sigap melayani masyarakat\n".
                    "   • Mengutamakan kepuasan publik\n\n".
                    "4. KEMAMPUAN BERADAPTASI\n".
                    "   • Fleksibel terhadap perubahan\n".
                    "   • Mampu bekerja dalam tim\n\n".
                    "5. KERJA MANDIRI DAN TUNTAS\n".
                    "   • Inisiatif tanpa harus diperintah\n".
                    "   • Menyelesaikan pekerjaan sampai selesai"
            ];
        }
        
        return view('materi', compact('materi', 'category'));
    }
    
    // Mulai test
    public function test($category)
    {
        $questions = Question::where('category', $category)->get();
        
        // Jika belum ada soal di database, tampilkan contoh soal
        if ($questions->isEmpty()) {
            $questions = $this->getContohSoal($category);
        }
        
        return view('test', compact('questions', 'category'));
    }
    
    // Submit jawaban
    public function submit(Request $request, $category)
    {
        $answers = $request->input('answers', []);
        $questions = Question::where('category', $category)->get();
        
        if ($questions->isEmpty()) {
            $questions = $this->getContohSoal($category);
        }
        
        $score = 0;
        $results = [];
        
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            $isCorrect = ($userAnswer == $question->correct_answer);
            
            if ($isCorrect) {
                $score++;
            }
            
            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect
            ];
        }
        
        $total = count($questions);
        
        return view('result', compact('score', 'total', 'results', 'category'));
    }
    
    // Contoh soal jika database kosong
    private function getContohSoal($category)
    {
        if ($category == 'twk') {
            return collect([
                (object) [
                    'id' => 1,
                    'question_text' => 'Pancasila sebagai dasar negara disahkan pada tanggal...',
                    'option_a' => '17 Agustus 1945',
                    'option_b' => '18 Agustus 1945',
                    'option_c' => '1 Juni 1945',
                    'option_d' => '22 Juni 1945',
                    'option_e' => '17 Juli 1945',
                    'correct_answer' => 'b'
                ],
                (object) [
                    'id' => 2,
                    'question_text' => 'Sila pertama Pancasila adalah...',
                    'option_a' => 'Kemanusiaan yang adil dan beradab',
                    'option_b' => 'Persatuan Indonesia',
                    'option_c' => 'Kerakyatan yang dipimpin oleh hikmat kebijaksanaan',
                    'option_d' => 'Ketuhanan Yang Maha Esa',
                    'option_e' => 'Keadilan sosial bagi seluruh rakyat Indonesia',
                    'correct_answer' => 'd'
                ],
                (object) [
                    'id' => 3,
                    'question_text' => 'Bendera Indonesia disebut...',
                    'option_a' => 'Merah Putih',
                    'option_b' => 'Sang Saka Merah Putih',
                    'option_c' => 'Dwi Warna',
                    'option_d' => 'Merah dan Putih',
                    'option_e' => 'Sang Merah Putih',
                    'correct_answer' => 'b'
                ],
                (object) [
                    'id' => 4,
                    'question_text' => 'Lagu kebangsaan Indonesia adalah...',
                    'option_a' => 'Indonesia Raya',
                    'option_b' => 'Rayuan Pulau Kelapa',
                    'option_c' => 'Garuda Pancasila',
                    'option_d' => 'Halo-halo Bandung',
                    'option_e' => 'Tanah Airku',
                    'correct_answer' => 'a'
                ],
                (object) [
                    'id' => 5,
                    'question_text' => 'Semboyan Bhinneka Tunggal Ika berarti...',
                    'option_a' => 'Bersatu kita teguh',
                    'option_b' => 'Berbeda-beda tetapi tetap satu',
                    'option_c' => 'Satu nusa satu bangsa',
                    'option_d' => 'Indonesia bersatu',
                    'option_e' => 'Kita semua saudara',
                    'correct_answer' => 'b'
                ]
            ]);
        } elseif ($category == 'tiu') {
            return collect([
                (object) [
                    'id' => 1,
                    'question_text' => 'Sinonim dari kata "KOMPETEN" adalah...',
                    'option_a' => 'Bodoh',
                    'option_b' => 'Mampu',
                    'option_c' => 'Malas',
                    'option_d' => 'Pandai',
                    'option_e' => 'Cerdik',
                    'correct_answer' => 'b'
                ],
                (object) [
                    'id' => 2,
                    'question_text' => 'Jika 2x + 5 = 15, maka nilai x adalah...',
                    'option_a' => '3',
                    'option_b' => '4',
                    'option_c' => '5',
                    'option_d' => '6',
                    'option_e' => '7',
                    'correct_answer' => 'c'
                ],
                (object) [
                    'id' => 3,
                    'question_text' => 'Antonim dari kata "MAJORITAS" adalah...',
                    'option_a' => 'Banyak',
                    'option_b' => 'Sedikit',
                    'option_c' => 'Minoritas',
                    'option_d' => 'Rata-rata',
                    'option_e' => 'Semua',
                    'correct_answer' => 'c'
                ],
                (object) [
                    'id' => 4,
                    'question_text' => 'Jika 3, 6, 12, 24, ..., maka angka selanjutnya adalah...',
                    'option_a' => '36',
                    'option_b' => '42',
                    'option_c' => '48',
                    'option_d' => '52',
                    'option_e' => '60',
                    'correct_answer' => 'c'
                ],
                (object) [
                    'id' => 5,
                    'question_text' => 'KAKI : SEPATU = TANGAN : ...',
                    'option_a' => 'CINCIN',
                    'option_b' => 'JAM TANGAN',
                    'option_c' => 'SARUNG TANGAN',
                    'option_d' => 'KUTU',
                    'option_e' => 'KAOS KAKI',
                    'correct_answer' => 'c'
                ]
            ]);
        } else {
            return collect([
                (object) [
                    'id' => 1,
                    'question_text' => 'Saat ada tugas kantor yang deadline-nya mepet, sikap Anda...',
                    'option_a' => 'Panik dan menyerah',
                    'option_b' => 'Bekerja lembur sampai selesai',
                    'option_c' => 'Menyalahkan orang lain',
                    'option_d' => 'Mencari alasan',
                    'option_e' => 'Menunda pekerjaan',
                    'correct_answer' => 'b'
                ],
                (object) [
                    'id' => 2,
                    'question_text' => 'Anda melihat rekan kerja melakukan kecurangan. Tindakan Anda...',
                    'option_a' => 'Membiarkan saja',
                    'option_b' => 'Ikut melakukannya',
                    'option_c' => 'Melaporkan ke atasan',
                    'option_d' => 'Mengingatkan secara baik-baik',
                    'option_e' => 'Bergosip dengan rekan lain',
                    'correct_answer' => 'd'
                ],
                (object) [
                    'id' => 3,
                    'question_text' => 'Seorang pemimpin yang baik seharusnya...',
                    'option_a' => 'Memerintah dengan keras',
                    'option_b' => 'Mendengarkan bawahan',
                    'option_c' => 'Mementingkan diri sendiri',
                    'option_d' => 'Tidak peduli dengan bawahan',
                    'option_e' => 'Hanya fokus pada target',
                    'correct_answer' => 'b'
                ],
                (object) [
                    'id' => 4,
                    'question_text' => 'Jika Anda diberi proyek baru, langkah pertama Anda adalah...',
                    'option_a' => 'Langsung mengerjakan',
                    'option_b' => 'Mencari tahu tujuan dan target proyek',
                    'option_c' => 'Menolak proyek',
                    'option_d' => 'Mencari orang untuk diajak kerja sama',
                    'option_e' => 'Menunda-nunda',
                    'correct_answer' => 'b'
                ],
                (object) [
                    'id' => 5,
                    'question_text' => 'Saat pelanggan komplain, tindakan Anda...',
                    'option_a' => 'Membantah',
                    'option_b' => 'Mendengarkan dan meminta maaf',
                    'option_c' => 'Mengabaikan',
                    'option_d' => 'Menyalahkan orang lain',
                    'option_e' => 'Pura-pura tidak tahu',
                    'correct_answer' => 'b'
                ]
            ]);
        }
    }
}