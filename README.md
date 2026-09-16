# Siperflex Attendance 🏫

> **Presensi Akurat, Refleksi Bermakna**

**Siperflex Attendance** adalah platform manajemen kehadiran sekolah modern berbasis Web dan _Progressive Web App_ (PWA). Platform ini dirancang dengan arsitektur **Multi-Tenant (Multi-School)**, memungkinkan banyak sekolah untuk menggunakan satu sistem terpusat tanpa mencampuradukkan data masing-masing entitas pendidikan.

Selain mencatat kehadiran dasar (Hadir, Sakit, Izin, Terlambat), Siperflex juga hadir dengan pendekatan holistik di mana siswa dapat membagikan kondisi emosional (_mood_) serta menuliskan jurnal refleksi harian mereka.

---

## ✨ Fitur Utama

- **Multi-School / Multi-Tenant Isolation:** Satu _codebase_ dan _database_ yang melayani banyak sekolah secara independen dan aman.
- **Geofencing & Verifikasi Lokasi:** Memastikan siswa hanya dapat melakukan presensi di area sekolah yang telah ditentukan (radius koordinat).
- **Photo Proof (Selfie Presensi):** Validasi kehadiran menggunakan jepretan kamera langsung.
- **Mood & Reflection Tracker:** Siswa dapat membagikan kondisi perasaan dan catatan refleksi, yang sangat berguna bagi Guru (Wali Kelas) untuk pendekatan personal.
- **Responsive & Modern UI:** Desain antarmuka _split-screen_ yang memukau di desktop, dan _Mobile-First_ yang sangat intuitif di perangkat HP siswa (PWA Ready).
- **Audit Logs:** Melacak aktivitas penting pengguna untuk menjaga keamanan operasional.

---

## 👥 Sistem Akses Berbasis Peran (RBAC)

Siperflex hanya menggunakan 4 peran (_roles_) utama tanpa peran "Staf" agar hierarki sistem lebih fokus dan terpusat:

1. **👑 Super Admin:** Berada pada level platform. Mengelola seluruh sekolah yang terdaftar, membuat akun Admin Sekolah, dan mengakses laporan lintas-sekolah.
2. **🏢 Admin Sekolah:** Administrator penuh untuk **satu sekolah**. Mengelola data Guru, Siswa, Kelas, Tahun Ajaran, serta mengatur konfigurasi presensi (termasuk _geofence_ radius).
3. **👨‍🏫 Guru (Wali Kelas):** Memantau rekapitulasi kehadiran, _mood_, dan refleksi harian siswa khusus untuk **kelas yang diampu** saja.
4. **👨‍🎓 Siswa:** Pengguna akhir yang melakukan presensi (dengan foto & lokasi), mencatat _mood_, dan melihat riwayat kehadiran mereka sendiri.

---

## 💻 Teknologi yang Digunakan

Proyek ini dibangun di atas tumpukan teknologi modern:

- **Backend:** [Laravel 11](https://laravel.com/) (PHP 8.2+)
- **Frontend Reactive:** [Livewire 3](https://livewire.laravel.com/) & [Alpine.js](https://alpinejs.dev/)
- **Styling:** [Tailwind CSS 3](https://tailwindcss.com/)
- **Database:** MySQL / MariaDB (Relational DB)
- **Asset Bundling:** Vite
- **Reporting:** `barryvdh/laravel-dompdf` (untuk export PDF)

---

## 🚀 Panduan Instalasi (Setup Lokal)

Ikuti langkah-langkah di bawah ini untuk menjalankan Siperflex di komputer Anda untuk keperluan pengembangan atau pengujian.

### 1. Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL atau MariaDB

### 2. Langkah-langkah Instalasi

1. **Clone repositori ini:**

    ```bash
    git clone https://github.com/mkeyzxi/siperflex-absensi-sekolah.git
    cd siperflex-attendance
    ```

2. **Instal dependensi PHP & Node.js:**

    ```bash
    composer install
    npm install
    ```

3. **Atur konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env`.

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan sesuaikan kredensial database Anda (terutama `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

5. **Migrasi Database & Seeding Dummy Data:**
   Perintah ini akan membangun struktur tabel relasional dan mengisi data percobaan awal.

    ```bash
    php artisan migrate:fresh --seed
    ```

6. **Jalankan Aplikasi (Development Server):**
   Aplikasi menggunakan Vite, jadi Anda harus menjalankan server PHP dan Node.js secara bersamaan.

    Buka terminal pertama untuk _assets (Vite)_:

    ```bash
    npm run dev
    ```

    Buka terminal kedua untuk server Laravel:

    ```bash
    php artisan serve
    ```

    Aplikasi sekarang dapat diakses melalui browser di: `http://localhost:8000`

---

## 🔑 Akun Uji Coba (Testing Accounts)

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat menguji akses untuk setiap _role_ menggunakan kredensial di bawah ini.

**Password untuk semua akun adalah:** `password`

| Peran (Role)          | Username Default | Email Default                        |
| :-------------------- | :--------------- | :----------------------------------- |
| **Super Admin**       | `superadmin`     | `superadmin@siperflex.com`           |
| **Admin Sekolah**     | `adminsekolah`   | `admin@sman1siperflex.sch.id`        |
| **Guru (Wali Kelas)** | `budiguru`       | `budi@sman1siperflex.sch.id`         |
| **Siswa**             | `andisiswa`      | `andi@student.sman1siperflex.sch.id` |

> _Catatan: Form login bersifat fleksibel. Anda dapat masuk menggunakan Email, Username, NIS (bagi Siswa), atau NIP (bagi Guru)._

---

## 📄 Struktur Desain & Dokumentasi

Untuk memahami alur sistem secara komprehensif, Anda dapat membaca dokumentasi internal yang tersedia di repositori ini:

- `PRD.md` — Product Requirements Document yang mendefinisikan aturan _multi-tenant_ dan limitasi dari masing-masing entitas/pengguna.
- `DESIGN.md` — Spesifikasi UI/UX, Design Tokens, Spacing layout, dan pedoman komponen visual.

---

## ⚖️ Lisensi

Proyek ini adalah aplikasi tertutup (custom application) yang dibangun dengan Framework Laravel. Laravel berlisensi di bawah [MIT license](https://opensource.org/licenses/MIT).
