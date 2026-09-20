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

## 🌍 Menjalankan Proyek untuk Akses Publik (Tunneling)

Jika Anda ingin menguji proyek ini (terutama fitur kamera dan menginstal PWA) melalui perangkat lain seperti _smartphone_ tanpa perlu melakukan _hosting_ permanen, Anda dapat menggunakan **Localtunnel**.

1. **Build Aset Frontend (Wajib untuk Akses Publik):**
   Karena perangkat eksternal tidak dapat mengakses server Vite (`localhost:5173`), Anda harus melakukan _build_ aset CSS dan JS secara statis.

    ```bash
    npm run build
    ```

2. **Jalankan Server Laravel:**

    ```bash
    php artisan serve
    ```

    _(Pastikan server berjalan di port 8000)._

3. **Jalankan Localtunnel:**
   Buka terminal/command prompt baru, lalu jalankan:
    ```bash
    npx localtunnel --port 8000 --subdomain siperflex
    ```
    Tunggu hingga muncul pesan seperti `your url is: https://...`. Salin URL HTTPS tersebut dan buka di HP atau komputer lain.

> **Catatan:** Siperflex sudah dikonfigurasi untuk menangani _Mixed Content_ di balik proxy, sehingga tampilan CSS dan aset tidak akan berantakan meskipun diakses via HTTPS _localtunnel_.

---

## ⚡ Akses Cepat via Wi-Fi Lokal (Tanpa Delay)

Jika HP dan Laptop Anda berada dalam **jaringan Wi-Fi yang sama**, Anda bisa mendapatkan performa _real-time_ yang sangat cepat tanpa melalui Localtunnel.

1. **Cari IP Lokal Laptop Anda:**
   Buka terminal/CMD dan jalankan perintah `ipconfig` (Windows) atau `ifconfig` (Mac/Linux). Catat **IPv4 Address** (contoh: `192.168.1.5`).
2. **Jalankan Server dengan Binding IP:**
   Jalankan server Laravel dan arahkan ke semua _interface_ jaringan lokal:
    ```bash
    php artisan serve --host=0.0.0.0 --port=8000
    ```
3. **Akses dari HP:**
   Buka browser di HP Anda dan masukkan IP tersebut beserta portnya, contoh: `http://192.168.1.5:8000`.

> **Peringatan Fitur Kamera:** Mengakses via Wi-Fi lokal menggunakan protokol HTTP (bukan HTTPS). Karena aturan privasi browser modern, **fitur kamera (jepret foto presensi) mungkin diblokir secara otomatis** pada koneksi HTTP lokal. Gunakan cara ini hanya untuk menguji kecepatan, UI, atau _flow_ aplikasi secara keseluruhan. Gunakan Localtunnel jika ingin menguji fitur kamera di HP.

---

## 📱 Progressive Web App (PWA)

Aplikasi ini telah dikonfigurasi secara lengkap sebagai PWA (Progressive Web App).

- **Instalasi:** Saat Anda membuka web ini di peramban _smartphone_ (Chrome/Edge/Safari), sistem akan menawarkan _prompt_ "Add to Home Screen" atau "Install App". Aplikasi akan muncul selayaknya aplikasi _native_ di laci aplikasi HP Anda.
- **Dukungan Offline:** Terdapat _Service Worker_ yang secara otomatis menyimpan aset-aset penting, serta menampilkan halaman khusus (_Offline Fallback_) jika koneksi internet terputus.

## 🔑 Akun Uji Coba (Testing Accounts)

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat menguji akses untuk setiap _role_ menggunakan kredensial di bawah ini.

**Password untuk semua akun adalah:** `password`

### Akun Utama (SMA Negeri 1 Siperflex)

| Peran (Role)          | Email Default                        | NIS / NIP               |
| :-------------------- | :----------------------------------- | :---------------------- |
| **Super Admin**       | `superadmin@siperflex.com`           | -                       |
| **Admin Sekolah**     | `admin@sman1siperflex.sch.id`        | NIP:                    |
|  |
| **Guru (Wali Kelas)** | `budi@sman1siperflex.sch.id`         | NIP: 198502022012021002 |
| **Siswa**             | `andi@student.sman1siperflex.sch.id` | NIS: 12345              |

### Akun Dummy (SMA Dummy 1 - 5 Siperflex)

Berikut adalah daftar akun **Admin Sekolah** untuk masing-masing sekolah dummy yang digenerate otomatis:

| Sekolah         | Email Admin                 |
| :-------------- | :-------------------------- |
| **SMA Dummy 1** | `admin.sma1@siperflex.test` |
| **SMA Dummy 2** | `admin.sma2@siperflex.test` |
| **SMA Dummy 3** | `admin.sma3@siperflex.test` |
| **SMA Dummy 4** | `admin.sma4@siperflex.test` |
| **SMA Dummy 5** | `admin.sma5@siperflex.test` |

> _Catatan tambahan: Untuk Guru dan Siswa pada sekolah dummy, login bisa menggunakan Email masing-masing. Form login bersifat fleksibel. Anda dapat masuk menggunakan Email, NIS (bagi Siswa), atau NIP (bagi Guru dan Admin)._

---

## 📄 Struktur Desain & Dokumentasi

Untuk memahami alur sistem secara komprehensif, Anda dapat membaca dokumentasi internal yang tersedia di repositori ini:

- `PRD.md` — Product Requirements Document yang mendefinisikan aturan _multi-tenant_ dan limitasi dari masing-masing entitas/pengguna.
- `DESIGN.md` — Spesifikasi UI/UX, Design Tokens, Spacing layout, dan pedoman komponen visual.

---

## ⚖️ Lisensi

Proyek ini adalah aplikasi tertutup (custom application) yang dibangun dengan Framework Laravel. Laravel berlisensi di bawah [MIT license](https://opensource.org/licenses/MIT).
