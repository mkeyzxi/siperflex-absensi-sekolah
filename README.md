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

Jika Anda ingin menguji proyek ini (terutama fitur kamera dan menginstal PWA) melalui perangkat lain seperti _smartphone_ tanpa perlu melakukan _hosting_ permanen, Anda dapat menggunakan **Localtunnel** atau **Cloudflare Tunnel**.

### Opsi 1: Localtunnel

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

### Opsi 2: Cloudflare Tunnel

Alternatif yang lebih stabil dan aman untuk akses publik adalah **Cloudflare Tunnel**.

1. **Pastikan Cloudflare Tunnel sudah terinstal:**

    ```bash
    npx cloudflared tunnel --help
    ```

    Jika belum tersedia, install secara global atau jalankan lewat `npx` langsung.

2. **Jalankan Laravel di background:**

    ```bash
    php artisan serve --host=0.0.0.0 --port=8000
    ```

3. **Buat tunnel baru:**

    ```bash
    npx cloudflared tunnel --url http://localhost:8000
    ```

4. **Cloudflare akan menghasilkan URL HTTPS** seperti:

    ```bash
    https://nama-random.trycloudflare.com
    ```

5. **Buka URL tersebut dari HP atau browser lain**, lalu coba akses aplikasi.

> **Keunggulan Cloudflare Tunnel:** URL lebih stabil, dukungan HTTPS otomatis, dan lebih cocok untuk pengujian akses dari perangkat lain tanpa hosting permanen.

---

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

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat menguji akses untuk setiap _role_ menggunakan data berikut.

**Password untuk semua akun yang dibuat lewat seeder adalah:** `password123`

> Saat ini, seed default yang aktif mencakup dua sekolah utama: **SMA Negeri 1 Siperflex** dan **SMP Negeri 40 Makassar**. Data sekolah lain, termasuk yang berhubungan dengan SMPN 47 Makassar, telah dihapus dari seeder.

### Akun Utama

| Peran (Role)      | Email Default                    | Keterangan |
| :---------------- | :------------------------------- | :--------- |
| **Super Admin**   | `superadmin@siperflex.com`       | Platform-level |
| **Admin Sekolah** | `admin@sman1siperflex.sch.id`   | SMA Negeri 1 Siperflex |
| **Admin Sekolah** | `admin@smpn40.sch.id`           | SMP Negeri 40 Makassar |

### Guru & Siswa

Guru dan siswa dibuat otomatis oleh seeder berdasarkan data sekolah yang aktif. Anda dapat login dengan:

- **Email akun guru/siswa** yang tercatat di database
- **NIP** untuk akun guru/admin
- **NIS** untuk akun siswa

#### Contoh dari `AbsensiDataSeeder.php`

Berikut contoh akun yang benar-benar dibuat oleh seeder di [database/seeders/AbsensiDataSeeder.php](database/seeders/AbsensiDataSeeder.php):

| Peran | Nama | Contoh Login | Password |
| :----- | :---- | :----------- | :------- |
| **Guru** | `Sa'adah Layly, M.Pd.` | `sa'adahlaylympd@smpn40.sch.id` | `password123` |
| **Murid** | `Adriansyah` | `adriansyah183089@student.smpn40.sch.id` | `password123` |

> Catatan: format email di seeder mengikuti pola otomatis yang dibuat dari nama dan NIP/NIS masing-masing. Karena itu, contoh di atas hanya mewakili satu guru dan satu siswa yang ada di data seed yang aktif.

Jika Anda ingin melihat daftar akun yang benar-benar dibuat, cek hasil migrasi/seed dari database atau jalankan perintah berikut untuk melihat user yang aktif:

```bash
php artisan tinker
User::whereIn('role', ['super_admin', 'admin_sekolah', 'guru', 'siswa'])->get(['name', 'email', 'role', 'school_id']);
```

---

## 📄 Struktur Desain & Dokumentasi

Untuk memahami alur sistem secara komprehensif, Anda dapat membaca dokumentasi internal yang tersedia di repositori ini:

- `PRD.md` — Product Requirements Document yang mendefinisikan aturan _multi-tenant_ dan limitasi dari masing-masing entitas/pengguna.
- `DESIGN.md` — Spesifikasi UI/UX, Design Tokens, Spacing layout, dan pedoman komponen visual.

---

## ⚖️ Lisensi

Proyek ini adalah aplikasi tertutup (custom application) yang dibangun dengan Framework Laravel. Laravel berlisensi di bawah [MIT license](https://opensource.org/licenses/MIT).
