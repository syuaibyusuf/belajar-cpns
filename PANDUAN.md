# Panduan Penggunaan Aplikasi Belajar CPNS

Aplikasi web untuk belajar dan latihan soal seleksi CPNS (TWK, TIU, TKP).

---

## Daftar Isi

1. [Persyaratan Sistem](#1-persyaratan-sistem)
2. [Cara Instalasi](#2-cara-instalasi)
3. [Cara Menjalankan](#3-cara-menjalankan)
4. [Cara Penggunaan — Sisi User / Pengunjung](#4-cara-penggunaan--sisi-user--pengunjung)
5. [Cara Penggunaan — Sisi Admin](#5-cara-penggunaan--sisi-admin)
6. [Struktur Database](#6-struktur-database)
7. [Daftar Route / Endpoint](#7-daftar-route--endpoint)

---

## 1. Persyaratan Sistem

| Komponen | Keterangan |
|----------|------------|
| PHP | ^8.3 |
| Database | MySQL / MariaDB |
| Web Server | Laragon (Apache + Nginx) |
| Node.js | 18+ |
| Composer | 2.x |
| Ekstensi PHP | PDO, MySQL, GD, XML, JSON, Fileinfo |

---

## 2. Cara Instalasi

### 2.1 Clone / Letakkan Project

Letakkan project di folder Laragon, misalnya: `D:\laragon\www\belajar-cpns`

### 2.2 Install Dependency PHP

```bash
composer install
```

### 2.3 Setup Environment

```bash
copy .env.example .env
```

Atau jika file `.env` sudah ada, pastikan konfigurasi database sesuai:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belajar_cpns
DB_USERNAME=root
DB_PASSWORD=
```

### 2.4 Generate Key & Migrate

```bash
php artisan key:generate
php artisan migrate
```

### 2.5 (Opsional) Seed Data Awal

```bash
php artisan db:seed
```

Seeder akan membuat:
- **2 Admin**: `admin@admin.com / password` dan `editor@admin.com / password`
- **8 Materi** bawaan (TWK, TIU, TKP)
- Soal-soal contoh (jika ada)

### 2.6 Install Dependency Frontend & Build

```bash
npm install
npm run build
```

---

## 3. Cara Menjalankan

### Mode Development (semua process sekaligus)

```bash
composer run dev
```

Perintah di atas menjalankan 4 process bersamaan:
- `php artisan serve` — server Laravel di http://127.0.0.1:8000
- `php artisan queue:listen` — queue worker
- `php artisan pail` — log viewer
- `npm run dev` — Vite dev server (hot-reload frontend)

### Manual (satu per satu)

**Terminal 1 — Laravel Server:**
```bash
php artisan serve --port=8000
```

**Terminal 2 — Vite Hot Reload (opsional):**
```bash
npm run dev
```

### Mode Production

```bash
npm run build
```

Cukup akses via web server (Apache/Nginx) langsung ke folder `public/`.

---

## 4. Cara Penggunaan — Sisi User / Pengunjung

### 4.1 Dashboard Utama

**URL:** `/` (halaman utama)

Fitur:
- Statistik progress belajar (total soal dikerjakan, persentase per kategori)
- Menu navigasi ke semua fitur
- Sidebar dengan progress bar dan statistik TWK / TIU / TKP

### 4.2 Belajar Materi

**URL:** `/materi`

Fitur:
- Lihat semua materi berdasarkan kategori (TWK, TIU, TKP)
- Filter per kategori: `/materi/kategori/{twk|tiu|tkp}`
- Baca detail materi: `/materi/{id}`
- Konten mendukung gambar inline yang bisa diupload admin

Kategori materi:
| Kategori | Nama |
|----------|------|
| TWK | Tes Wawasan Kebangsaan |
| TIU | Tes Intelegensi Umum |
| TKP | Tes Karakteristik Pribadi |

### 4.3 Latihan Soal

**URL:** `/latihan`

Fitur:
- Pilih kategori (TWK, TIU, TKP)
- Pilih jumlah soal (10 / 15 / 20)
- Kerjakan soal langsung
- Lihat hasil & pembahasan setelah selesai
- Soal TKP menggunakan sistem skor per opsi (bukan benar/salah)

### 4.4 Paket Soal (50 Soal)

**URL:** `/packages`

Fitur:
- Pilih paket soal yang sudah dibuat admin (masing-masing 50 soal)
- Kerjakan soal: `/packages/{id}/start`
- Submit jawaban: `POST /packages/{id}/submit`
- Lihat hasil lengkap dengan skor & pembahasan

Tipe soal:
- **TWK / TIU**: Setiap soal memiliki 1 jawaban benar (A-E)
- **TKP**: Setiap opsi memiliki skor berbeda (1-5), total skor diakumulasi

### 4.5 Try Out

**URL:** `/tryouts`

Fitur:
- Simulasi ujian CPNS dengan 110 soal (TWK + TIU + TKP)
- Mirip skema paket soal, tapi dengan jumlah soal lebih banyak
- Kerjakan: `/tryouts/{id}/start`
- Submit: `POST /tryouts/{id}/submit`

### 4.6 Saran & Masukan

**URL:** `/saran`

Fitur:
- Kirim saran, kritik, atau masukan ke admin
- Form: nama, email, pesan
- Admin akan menerima dan bisa merespon

---

## 5. Cara Penggunaan — Sisi Admin

### 5.1 Login Admin

**URL:** `/admin/login`

| Email | Password | Role |
|-------|----------|------|
| admin@admin.com | password | superadmin |
| editor@admin.com | password | editor |

Setelah login, session akan tersimpan dan redirect ke dashboard admin.

Untuk logout: klik tombol **Logout** di sidebar.

### 5.2 Dashboard Admin

**URL:** `/admin`

Fitur:
- **Statistik Ringkas**: Total materi, total soal, total paket, user aktif, test diikuti
- **Grafik Aktivitas User** (7 hari terakhir)
- **5 Soal Paling Sering Salah** — soal dengan tingkat kesalahan tertinggi
- **Statistik per Kategori**: Jumlah soal TWK / TIU / TKP
- **Rata-rata Nilai User** per kategori
- **Materi & Paket Terbaru**
- **Menu Grid** cepat ke semua halaman manajemen

### 5.3 Manajemen Materi

**URL:** `/admin/materi`

**Lihat daftar materi** — tabel dengan pagination, ada status Published/Draft.

**Tambah materi** (`/admin/materi/create`):
| Field | Keterangan |
|-------|------------|
| Judul | Wajib, max 255 karakter |
| Kategori | TWK / TIU / TKP |
| Konten | Wajib, bisa pakai teks biasa |
| Thumbnail | Upload gambar (opsional) |
| Gambar inline | Bisa upload gambar yang disisipkan di konten via `[IMAGE_1]`, `[IMAGE_2]`, dst. |
| Urutan | Angka urutan tampil |
| Status | Published (tampil) / Draft (disembunyikan) |

**Edit materi** — sama seperti tambah, gambar bisa diupdate/dihapus.

**Hapus materi** — otomatis menghapus thumbnail & gambar terkait dari server.

**Toggle Status** — tombol untuk cepat mengubah Published/Draft via AJAX.

### 5.4 Manajemen Soal

**URL:** `/admin/soal`

**Lihat daftar soal** — filter by kategori, search teks, pagination 15 per halaman.

**Tambah soal** (`/admin/soal/create`):
| Field | Keterangan |
|-------|------------|
| Kategori | TWK / TIU / TKP |
| Teks Soal | Wajib |
| Gambar Soal | Base64 image (opsional) |
| Opsi A - E | Wajib diisi |
| Gambar Opsi A - E | Base64 image per opsi (opsional) |
| Kunci Jawaban | TWK/TIU: pilih A-E. TKP: tidak pakai kunci |
| Skor Opsi A-E | Khusus TKP: nilai 1-5 per opsi |
| Pembahasan | Opsional, tampil setelah user selesai ujian |
| Tingkat Kesulitan | Easy / Medium / Hard |
| Poin | Default 5 |

**Edit soal** — sama seperti tambah.

**Hapus soal** — konfirmasi lalu hapus.

**Download Template CSV** — `/admin/soal/export/template` — untuk import massal.

**Export Soal CSV** — `/admin/soal/export` — download semua soal dalam format CSV.

### 5.5 Manajemen Paket Soal (50 Soal)

**URL:** `/admin/packages`

**Tambah paket:**
| Field | Keterangan |
|-------|------------|
| Nama Paket | Wajib |
| Kategori | TWK / TIU / TKP |
| Deskripsi | Opsional |
| Jumlah Soal | 1-100 (biasanya 50) |

Setelah membuat paket, langsung diarahkan ke halaman **edit soal** untuk mengisi soal satu per satu.

**Edit Soal dalam Paket** (`/admin/packages/{id}/edit-questions`):
- Form untuk setiap nomor soal (1 sampai total_questions)
- Field: teks soal, 5 opsi, kunci jawaban (A-E), pembahasan
- Khusus TKP: input skor per opsi (1-5)
- Jika semua soal terisi, status paket otomatis menjadi **Active**
- Jika belum lengkap, status tetap **Draft**

**Edit informasi paket** — ubah nama, kategori, deskripsi, status.

**Duplikasi paket** — copy paket + seluruh soal, status Draft, siap diedit.

**Hapus paket** — beserta semua soal di dalamnya.

### 5.6 Manajemen Try Out (110 Soal)

**URL:** `/admin/tryouts`

Sama persis dengan Paket Soal, tapi untuk skema Try Out dengan 110 soal (gabungan TWK + TIU + TKP).

Fitur:
- CRUD Try Out
- Edit soal try out (per nomor)
- Duplikasi try out
- Hapus try out

### 5.7 Manajemen Feedback / Saran

**URL:** `/admin/feedback`

Fitur:
- Lihat daftar saran & masukan dari user
- Status: **Unread** (belum dibaca), **Read** (dibaca), **Responded** (direspon)
- Lihat detail pesan
- Hapus feedback

### 5.8 Statistik

**URL:** `/admin/statistik` (via dashboard → menu Statistik)

Fitur:
- Grafik progress user per minggu (7 hari)
- Breakdown per kategori (TWK, TIU, TKP)
- Rata-rata nilai user per kategori

### 5.9 Backup Database

**URL:** `/admin/backup`

Fitur:
- **Buat Backup** — menyimpan dump database SQL ke `storage/app/backup/`
- **Download Backup** — download file `.sql`
- **Restore Backup** — upload dan restore file backup
- **Hapus Backup** — hapus file backup dari server

---

## 6. Struktur Database

### Tabel `admins`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| name | string | Nama admin |
| email | string | Email login |
| password | string | Hash password |
| role | string | superadmin / editor |
| timestamps | - | created_at, updated_at |

### Tabel `materi`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| title | string | Judul materi |
| category | enum | twk, tiu, tkp |
| content | text | Konten materi |
| thumbnail | string, nullable | File gambar thumbnail |
| content_images | text, nullable | JSON daftar gambar inline |
| order_number | integer | Urutan tampil |
| status | enum | published, draft |
| created_by | bigint, nullable | Foreign key ke admins |
| timestamps | - | created_at, updated_at |

### Tabel `questions` (Soal Bank)
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| category | enum | twk, tiu, tkp |
| question_text | text | Teks soal |
| question_image | text, nullable | Base64 gambar soal |
| option_a / b / c / d / e | text | Teks opsi |
| image_a / b / c / d / e | text, nullable | Base64 gambar opsi |
| correct_answer | char, nullable | a/b/c/d/e (null untuk TKP) |
| score_a / b / c / d / e | integer, default 0 | Skor per opsi (khusus TKP) |
| explanation | text, nullable | Pembahasan |
| difficulty | enum | easy, medium, hard |
| points | integer | Poin (default 5) |
| created_by | bigint, nullable | Foreign key ke admins |
| timestamps | - | created_at, updated_at |

### Tabel `packages` (Paket 50 Soal)
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| name | string | Nama paket |
| category | enum | twk, tiu, tkp |
| description | text, nullable | Deskripsi |
| total_questions | integer | Jumlah soal (biasanya 50) |
| status | enum | draft, active |
| created_by | bigint, nullable | Foreign key ke admins |
| timestamps | - | created_at, updated_at |

### Tabel `package_questions`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| package_id | bigint | Foreign key ke packages |
| order_number | integer | Nomor urut soal |
| question_text | text | Teks soal |
| question_image | text, nullable | Base64 gambar |
| option_a / b / c / d / e | text | Opsi |
| correct_answer | char, nullable | a/b/c/d/e atau null (TKP) |
| score_a / b / c / d / e | integer | Skor per opsi (TKP) |
| explanation | text, nullable | Pembahasan |
| timestamps | - | created_at, updated_at |

### Tabel `tryouts` (sama seperti packages)
Sama struktur seperti packages, untuk try out 110 soal.

### Tabel `tryout_questions` (sama seperti package_questions)
Sama struktur seperti package_questions.

### Tabel `user_progress`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| session_id | string | Session identifier |
| type | string | quick / package / tryout |
| category | string | twk / tiu / tkp |
| package_id | bigint, nullable | ID paket/tryout |
| score | integer | Skor akhir |
| total_questions | integer | Total soal |
| answers | text, nullable | JSON jawaban user |
| timestamps | - | created_at, updated_at |

### Tabel `feedbacks`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| name | string | Nama pengirim |
| email | string | Email pengirim |
| message | text | Isi pesan |
| status | enum | unread, read, responded |
| admin_response | text, nullable | Respon dari admin |
| timestamps | - | created_at, updated_at |

---

## 7. Daftar Route / Endpoint

### User Routes (tanpa login)

| Method | URL | Nama Route | Fungsi |
|--------|-----|------------|--------|
| GET | `/` | `home` | Dashboard utama |
| GET | `/materi` | `materi.index` | Daftar semua materi |
| GET | `/materi/kategori/{category}` | `materi.by-category` | Materi per kategori |
| GET | `/materi/{id}` | `materi.detail` | Detail materi |
| GET | `/latihan` | `latihan` | Halaman latihan soal |
| GET | `/packages` | `packages.index` | Daftar paket soal |
| GET | `/packages/{id}/start` | `packages.start` | Mulai kerjakan paket |
| POST | `/packages/{id}/submit` | `packages.submit` | Submit jawaban paket |
| GET | `/tryouts` | `tryouts.index` | Daftar try out |
| GET | `/tryouts/{id}/start` | `tryouts.start` | Mulai try out |
| POST | `/tryouts/{id}/submit` | `tryouts.submit` | Submit jawaban try out |
| GET | `/saran` | `feedback.page` | Form saran & masukan |
| POST | `/saran` | `feedback.store` | Kirim saran & masukan |

### Admin Routes

| Method | URL | Nama Route | Fungsi |
|--------|-----|------------|--------|
| GET | `/admin/login` | `admin.login` | Form login admin |
| POST | `/admin/login` | — | Proses login |
| POST | `/admin/logout` | `admin.logout` | Logout admin |
| **GET** | **`/admin`** | **`admin.dashboard`** | **Dashboard admin** |
| GET | `/admin/materi` | `admin.materi.index` | Daftar materi |
| GET | `/admin/materi/create` | `admin.materi.create` | Form tambah materi |
| POST | `/admin/materi` | `admin.materi.store` | Simpan materi baru |
| GET | `/admin/materi/{id}/edit` | `admin.materi.edit` | Form edit materi |
| PUT | `/admin/materi/{id}` | `admin.materi.update` | Update materi |
| DELETE | `/admin/materi/{id}` | `admin.materi.destroy` | Hapus materi |
| POST | `/admin/materi/{id}/toggle-status` | `admin.materi.toggle` | Toggle publish/draft |
| GET | `/admin/soal` | `admin.soal.index` | Daftar soal |
| GET | `/admin/soal/create` | `admin.soal.create` | Form tambah soal |
| POST | `/admin/soal` | `admin.soal.store` | Simpan soal baru |
| GET | `/admin/soal/{id}/edit` | `admin.soal.edit` | Form edit soal |
| PUT | `/admin/soal/{id}` | `admin.soal.update` | Update soal |
| DELETE | `/admin/soal/{id}` | `admin.soal.destroy` | Hapus soal |
| GET | `/admin/soal/export/template` | `admin.soal.template` | Download template CSV |
| GET | `/admin/soal/export` | `admin.soal.export` | Export semua soal CSV |
| GET | `/admin/packages` | `admin.packages.index` | Daftar paket soal |
| GET | `/admin/packages/create` | `admin.packages.create` | Form tambah paket |
| POST | `/admin/packages` | `admin.packages.store` | Simpan paket baru |
| GET | `/admin/packages/{id}/edit` | `admin.packages.edit` | Form edit paket |
| PUT | `/admin/packages/{id}` | `admin.packages.update` | Update paket |
| DELETE | `/admin/packages/{id}` | `admin.packages.destroy` | Hapus paket |
| GET | `/admin/packages/{id}/edit-questions` | `admin.packages.edit-questions` | Edit soal dalam paket |
| POST | `/admin/packages/{id}/save-questions` | `admin.packages.save-questions` | Simpan soal paket |
| POST | `/admin/packages/{id}/duplicate` | `admin.packages.duplicate` | Duplikasi paket |
| GET | `/admin/tryouts` | `admin.tryouts.index` | Daftar try out |
| GET | `/admin/tryouts/create` | `admin.tryouts.create` | Form tambah try out |
| POST | `/admin/tryouts` | `admin.tryouts.store` | Simpan try out |
| GET | `/admin/tryouts/{id}/edit` | `admin.tryouts.edit` | Form edit try out |
| PUT | `/admin/tryouts/{id}` | `admin.tryouts.update` | Update try out |
| DELETE | `/admin/tryouts/{id}` | `admin.tryouts.destroy` | Hapus try out |
| GET | `/admin/tryouts/{id}/edit-questions` | `admin.tryouts.edit-questions` | Edit soal try out |
| POST | `/admin/tryouts/{id}/save-questions` | `admin.tryouts.save-questions` | Simpan soal try out |
| POST | `/admin/tryouts/{id}/duplicate` | `admin.tryouts.duplicate` | Duplikasi try out |
| GET | `/admin/feedback` | `admin.feedback.index` | Daftar feedback |
| GET | `/admin/feedback/{id}` | `admin.feedback.show` | Detail feedback |
| DELETE | `/admin/feedback/{id}` | `admin.feedback.destroy` | Hapus feedback |
| POST | `/admin/feedback/{id}/respond` | `admin.feedback.respond` | Respon feedback |
| GET | `/admin/backup` | `admin.backup.index` | Halaman backup |
| POST | `/admin/backup/create` | `admin.backup.create` | Buat backup database |
| GET | `/admin/backup/download/{filename}` | `admin.backup.download` | Download file backup |
| DELETE | `/admin/backup/delete/{filename}` | `admin.backup.delete` | Hapus file backup |
| POST | `/admin/backup/restore` | `admin.backup.restore` | Restore dari file backup |
