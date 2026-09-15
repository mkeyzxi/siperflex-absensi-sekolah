# Siperflex Attendance 🏫

Siperflex Attendance adalah sistem presensi sekolah modern berbasis web yang dibangun menggunakan **Laravel 11**, **Livewire 3**, dan **Tailwind CSS**. Sistem ini memfasilitasi manajemen kehadiran siswa secara digital dengan pendekatan reflektif, memungkinkan siswa tidak hanya melakukan absensi tetapi juga membagikan kondisi *mood* dan jurnal harian mereka.

## 🌟 Fitur Utama

Aplikasi ini menggunakan sistem akses berbasis peran (*Role-Based Access Control*) dengan tingkatan sebagai berikut:

- **👨‍🎓 Siswa**
  - Mengisi absensi harian (Hadir, Sakit, Izin, Terlambat).
  - Melaporkan kondisi perasaan (*Mood*) hari ini.
  - Menulis jurnal atau refleksi harian.
  - (Mendukung pelacakan koordinat lokasi dan bukti foto absensi berdasarkan skema *database*).
- **👨‍🏫 Guru (Wali Kelas)**
  - Melihat rekapitulasi kehadiran siswa di kelas yang diampu secara *real-time*.
  - Melihat detail *mood* dan refleksi masing-masing siswa untuk pendekatan pembelajaran yang lebih personal.
- **🏢 Admin Sekolah**
  - Mengelola data operasional sekolah (Guru, Siswa, Kelas).
- **👑 Super Admin**
  - Mengelola sistem secara keseluruhan (Manajemen multi-sekolah).

## 💻 Teknologi yang Digunakan

- [Laravel 11](https://laravel.com/) - Framework PHP
- [Livewire 3](https://livewire.laravel.com/) - Dynamic UI Components
- [Tailwind CSS 3](https://tailwindcss.com/) - Utility-first CSS Framework
- MySQL - Database Relasional

## 🚀 Panduan Instalasi (Setup)

Ikuti langkah-langkah di bawah ini untuk menjalankan Siperflex secara lokal di komputer Anda.

### 1. Kebutuhan Sistem
Pastikan Anda telah menginstal perangkat lunak berikut:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL atau MariaDB

### 2. Langkah Instalasi

1. **Clone repositori ini:**
   ```bash
   git clone <url-repo-anda>
   cd siperflex-attendance
   ```

2. **Instal dependensi PHP & Node:**
   ```bash
   composer install
   npm install
   ```

3. **Atur konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan kredensial database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=siperflex_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding:**
   Perintah ini akan membuat struktur tabel yang diperlukan beserta data percobaan (dummy).
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan Aplikasi:**
   Untuk menjalankan aplikasi, Anda perlu mengaktifkan *dev server* untuk Vite (CSS/JS) dan Laravel secara bersamaan di terminal yang terpisah:

   *Terminal 1 (Vite):*
   ```bash
   npm run dev
   ```

   *Terminal 2 (Laravel):*
   ```bash
   php artisan serve
   ```

   Aplikasi dapat diakses di: `http://localhost:8000`

---

## 🔑 Akun Uji Coba (Testing Accounts)

Anda dapat menggunakan akun-akun berikut untuk menguji *role* masing-masing pengguna di aplikasi. **Password untuk semua akun di bawah adalah:** `password`

| Role | Username | Email |
| :--- | :--- | :--- |
| **Super Admin** | `superadmin` | `superadmin@siperflex.com` |
| **Admin Sekolah** | `adminsekolah` | `admin@sman1siperflex.sch.id` |
| **Guru Wali Kelas** | `budiguru` | `budi@sman1siperflex.sch.id` |
| **Siswa** | `andisiswa` | `andi@student.sman1siperflex.sch.id` |

> *Catatan: Login juga dapat menggunakan identitas alternatif yang terdaftar di database, seperti NIS (Siswa) atau NIP (Guru/Admin).*

## 📄 Lisensi
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). Proyek ini merupakan aplikasi kustom yang dikembangkan untuk tujuan spesifik.
