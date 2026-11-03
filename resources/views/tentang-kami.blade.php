<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - SIPERFLEX</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo-transparan.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo-transparan.png') }}">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="Tentang Kami - SIPERFLEX">
    <meta property="og:description" content="Sistem Informasi Presensi dan Refleksi Fleksibel untuk Sekolah.">
    <meta property="og:image" content="{{ asset('logo-login.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi halus untuk hero & card */
        .animate-fade-up {
            animation: fadeUp 0.7s ease-out both;
        }
        .animate-fade-up.delay-1 { animation-delay: 0.1s; }
        .animate-fade-up.delay-2 { animation-delay: 0.2s; }
        .animate-fade-up.delay-3 { animation-delay: 0.3s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(60px);
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-neutral-bg text-neutral-900 font-sans antialiased min-h-screen">

    <!-- Header/Navigation -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md shadow-sm border-b border-neutral-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('tentang.kami') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.webp') }}" alt="SIPERFLEX Logo" class="h-8 sm:h-9">
                <div class="leading-tight">
                    <h1 class="text-lg sm:text-xl font-bold text-neutral-800">SIPERFLEX</h1>
                    <p class="text-[10px] sm:text-[11px] font-medium text-neutral-500 hidden sm:block">Presensi Akurat, Refleksi Bermakna</p>
                </div>
            </a>
            <nav class="flex items-center gap-3 sm:gap-6">
                <a href="{{ route('login') }}"
                   class="text-xs sm:text-sm font-medium text-neutral-600 hover:text-primary-600 transition-colors">Halaman Masuk</a>
                {{-- <a href="{{ url('/admin/dashboard') }}"
                   class="hidden sm:inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 px-3.5 sm:px-4 py-2 rounded-lg shadow-sm transition-colors">
                    Masuk Panel
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"></path>
                    </svg>
                </a> --}}
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pb-16">

        <!-- ===== Hero Section ===== -->
        <section class="relative overflow-hidden bg-gradient-to-br from-primary-800 via-primary-700 to-primary-500 text-white">
            <!-- Dekorasi blob -->
            <div class="hero-blob w-72 h-72 bg-primary-400 -top-10 -left-10"></div>
            <div class="hero-blob w-80 h-80 bg-info-500 top-1/2 -right-16"></div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 py-14 md:py-20 relative z-10">
                <div class="animate-fade-up flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <!-- Logo -->
                    <div class="shrink-0">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 bg-white/10 border border-white/20 rounded-3xl flex items-center justify-center backdrop-blur-sm">
                            <img src="{{ asset('logo-transparan.png') }}" alt="Logo SIPERFLEX"
                                 class="w-16 h-16 sm:w-20 sm:h-20 object-contain">
                        </div>
                    </div>

                    <!-- Teks -->
                    <div class="text-center md:text-left">
                        {{-- <span class="animate-fade-up inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs font-semibold text-primary-100 mb-4"> --}}
                            <span class="w-2 h-2 rounded-full bg-success-500"></span>
                            Berbasis Web &middot; Sejak 2026
                        {{-- </span> --}}
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
                            Tentang <span class="text-primary-200">SIPERFLEX</span>
                        </h1>
                        <p class="mt-4 text-sm sm:text-base text-primary-100/90 max-w-2xl leading-relaxed">
                            <strong>Sistem Informasi Presensi dan Refleksi Fleksibel</strong> untuk
                            SMP Negeri 40 Makassar — pencatatan kehadiran yang praktis, terstruktur,
                            dan mudah ditelusuri secara digital.
                        </p>
                        <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-3">
                            <a href="#tim" class="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold text-sm px-5 py-2.5 rounded-xl shadow-lg hover:bg-primary-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Kenali Timnya
                            </a>
                            <a href="#visi-misi"
                               class="inline-flex items-center gap-2 bg-white/10 border border-white/30 text-white font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-white/20 transition-colors">
                                Visi &amp; Misi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gelombang pemisah -->
            <div class="relative">
                <svg class="block w-full h-8 md:h-12 text-neutral-bg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none" fill="currentColor">
                    <path d="M0,40 C240,80 480,0 720,32 C960,64 1200,8 1440,40 L1440,80 L0,80 Z"></path>
                </svg>
            </div>
        </section>

        <!-- ===== Fakta Singkat (Stat) ===== -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 -mt-4 relative z-10 mb-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                <div class="animate-fade-up delay-1 bg-white rounded-2xl shadow-sm border border-neutral-200/70 p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <p class="text-2xl sm:text-3xl font-extrabold text-primary-600">2026</p>
                    <p class="text-[11px] sm:text-xs font-medium text-neutral-500 mt-1">Tahun Lahir</p>
                </div>
                <div class="animate-fade-up delay-1 bg-white rounded-2xl shadow-sm border border-neutral-200/70 p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <p class="text-2xl sm:text-3xl font-extrabold text-primary-600">4</p>
                    <p class="text-[11px] sm:text-xs font-medium text-neutral-500 mt-1">Peran Pengguna</p>
                </div>
                <div class="animate-fade-up delay-2 bg-white rounded-2xl shadow-sm border border-neutral-200/70 p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <p class="text-2xl sm:text-3xl font-extrabold text-primary-600">B</p>
                    <p class="text-[11px] sm:text-xs font-medium text-neutral-500 mt-1">Akreditasi Sekolah</p>
                </div>
                <div class="animate-fade-up delay-2 bg-white rounded-2xl shadow-sm border border-neutral-200/70 p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <p class="text-2xl sm:text-3xl font-extrabold text-primary-600">720</p>
                    <p class="text-[11px] sm:text-xs font-medium text-neutral-500 mt-1">Siswa Terlayani</p>
                </div>
            </div>
        </section>

        <!-- ===== Grid Konten ===== -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 space-y-6">

            <!-- Tentang Sekolah -->
            <div class="animate-fade-up bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-primary-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-neutral-900">Tentang Sekolah</h2>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-neutral-700 text-base leading-relaxed">
                        SMP Negeri 40 Makassar, yang secara resmi bernama
                        <strong>UPT SPF SMP Negeri 40 Makassar</strong>, adalah sekolah menengah
                        pertama negeri di bawah naungan pemerintah daerah yang berlokasi di
                        Kecamatan Rappocini, Kota Makassar, tepatnya di Jl. Aroepala. Sekolah ini
                        terakreditasi <strong>B</strong>, menggunakan <strong>Kurikulum Merdeka</strong>,
                        dan dipimpin oleh <strong>Nurhadiawati, S.Pd., M.Pd.</strong> selaku kepala
                        sekolah. Berdasarkan data Kemendikdasmen, sekolah ini memiliki 48 guru dan
                        sekitar 720 siswa dalam 24 rombongan belajar, serta fasilitas berupa 2
                        laboratorium dan 1 perpustakaan di atas lahan seluas 10.000&nbsp;m².
                        Sekolah ini dikenal sebagai sekolah <strong>Adiwiyata Mandiri</strong>
                        di Sulawesi Selatan.
                    </p>
                    <!-- Ciri khas sekolah -->
                    <div class="mt-5 grid sm:grid-cols-3 gap-3">
                        <div class="flex items-center gap-3 bg-success-100/60 border border-success-700/10 rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-success-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-success-700">Adiwiyata Mandiri</p>
                                <p class="text-[11px] text-success-600/80">Sulawesi Selatan</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-info-100/60 border border-info-700/10 rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-info-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-info-700">Kurikulum Merdeka</p>
                                <p class="text-[11px] text-info-600/80">24 rombel &middot; 48 guru</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 bg-warning-100/60 border border-warning-700/10 rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-warning-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-warning-700">Akreditasi B</p>
                                <p class="text-[11px] text-warning-700/80">Negeri &middot; Makassar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apa Itu SIPERFLEX -->
            <div class="animate-fade-up delay-1 bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-info-100 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-info-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-info-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-neutral-900">Apa Itu SIPERFLEX?</h2>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-neutral-700 text-base leading-relaxed">
                        Siperflex adalah <strong>Sistem Informasi Presensi Fleksibel Berbasis
                        Digital</strong> yang dapat diakses oleh empat komponen pengguna, yaitu
                        super admin, admin, guru, dan siswa. Aplikasi ini dirancang untuk
                        mencatat dan memantau kehadiran secara digital sehingga proses
                        pencatatan menjadi lebih praktis, terstruktur, dan mudah ditelusuri
                        dibandingkan presensi manual.
                    </p>
                    <!-- Empat peran pengguna -->
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="flex items-center gap-3 bg-neutral-50 border border-neutral-100 rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-danger-100 text-danger-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.597 3.824 10.29 9 11.622 5.176-1.332 9-6.025 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <p class="text-xs sm:text-sm font-semibold text-neutral-700">Super Admin</p>
                        </div>
                        <div class="flex items-center gap-3 bg-neutral-50 border border-neutral-100 rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.068c1.543-.94 3.31.828 2.37 2.37a1.724 1.724 0 001.068 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.068 2.573c.94 1.543-.828 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.068c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.068c-1.543.94-3.31-.828-2.37-2.37a1.724 1.724 0 00-1.068-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.068-2.573c-.94-1.543.828-3.31 2.37-2.37.996.608 2.296.07 2.572-1.068z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7a4 4 0 108 0 4 4 0 00-8 0z"></path>
                                </svg>
                            </div>
                            <p class="text-xs sm:text-sm font-semibold text-neutral-700">Admin Sekolah</p>
                        </div>
                        <div class="flex items-center gap-3 bg-neutral-50 border border-neutral-100 rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-success-100 text-success-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0v7"></path>
                                </svg>
                            </div>
                            <p class="text-xs sm:text-sm font-semibold text-neutral-700">Guru</p>
                        </div>
                        <div class="flex items-center gap-3 bg-neutral-50 border border-neutral-100 rounded-xl p-3">
                            <div class="w-9 h-9 rounded-lg bg-warning-100 text-warning-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 14v3m4-3v3m4-3v3M3 7v3a9 9 0 0118 0v3M3 7h3M21 7h-3m-6 7h.01M8 11h.01M16 11h.01"></path>
                                </svg>
                            </div>
                            <p class="text-xs sm:text-sm font-semibold text-neutral-700">Siswa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latar Belakang -->
            <div class="animate-fade-up delay-2 bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-warning-100 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-warning-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-neutral-900">Latar Belakang Lahirnya Siperflex</h2>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-neutral-700 text-base leading-relaxed">
                        Siperflex terealisasikan tahun 2026 dari sebuah projek kepemimpinan yang
                        dikerjakan oleh mahasiswa PPL <strong>Program Profesi Guru (PPG)
                        Universitas Negeri Makassar (UNM)</strong> di SMP Negeri 40 Makassar.
                        Projek ini dikerjakan oleh kelompok mahasiswa yang berkolaborasi untuk
                        mengatasi kendala pencatatan kehadiran yang masih dilakukan secara manual.
                        Keberhasilan pengembangan projek ini tidak lepas dari bimbingan
                        <strong>Pak Sufitryono, S.Pd., M.Pd.</strong> selaku dosen pengampu mata
                        kuliah serta <strong>Fanna Sriwati, S.Pd.</strong> selaku guru pamong.
                    </p>
                </div>
            </div>

            <!-- Visi & Misi -->
            <div id="visi-misi" class="animate-fade-up delay-2 scroll-mt-24 bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-success-100 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-success-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-neutral-900">Visi &amp; Misi</h2>
                    </div>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <div class="relative bg-gradient-to-r from-primary-600 to-primary-500 rounded-2xl p-5 sm:p-6 text-white shadow-md overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold uppercase tracking-wider text-primary-200 mb-1">Visi</p>
                            <p class="text-base leading-relaxed">
                                Menjadi sistem informasi presensi digital yang andal, mudah
                                digunakan, dan transparan dalam mendukung terciptanya budaya
                                disiplin serta tertib administrasi di lingkungan sekolah.
                            </p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <p class="text-xs font-bold uppercase tracking-wider text-neutral-400">Misi</p>
                        <ol class="space-y-2">
                            @php
                                $misi = [
                                    'Menyediakan sistem absensi digital yang praktis, cepat, dan mudah diakses.',
                                    'Menggantikan pencatatan kehadiran manual dengan sistem yang lebih akurat, efisien, dan minim kesalahan.',
                                    'Menyajikan data kehadiran secara real-time dan rapi sehingga mudah dipantau serta direkap oleh pihak yang berwenang.',
                                    'Menerapkan pembagian hak akses sesuai peran pengguna untuk menjaga keamanan dan keteraturan data.',
                                    'Mendorong kedisiplinan dan tanggung jawab seluruh warga sekolah melalui pemanfaatan teknologi digital.',
                                ];
                            @endphp
                            @foreach ($misi as $i => $teks)
                                <li class="flex items-start gap-3 bg-neutral-50 border border-neutral-100 rounded-xl p-3.5">
                                    <span class="w-7 h-7 shrink-0 rounded-full bg-primary-600 text-white text-xs font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                                    <p class="text-base text-neutral-700 leading-relaxed">{{ $teks }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Tim Pengembang -->
            @php
                $timSmp40 = ['Via Ahsani', 'Abd. Rahman', 'Muhammad Alqadri', 'Haldiyanto', 'Muh. Nur Abriansyah'];
                $timSmp47 = ['Khusnul Khotimah', 'Irfan Burhan', 'Ramli', 'Ruswaldi', 'Riyadi Ramdani Basri'];

                // 10 gradasi warna berbeda untuk avatar inisial
                $warnaAv = [
                    'bg-primary-600',
                    'bg-info-500',
                    'bg-success-500',
                    'bg-warning-500',
                    'bg-danger-500',
                    'bg-primary-700',
                    'bg-info-700',
                    'bg-success-700',
                    'bg-warning-700',
                    'bg-danger-700',
                ];

                $buatInisial = function (string $nama): string {
                    return strtoupper(collect(explode(' ', $nama))
                        ->take(2)
                        ->map(fn ($kata) => mb_substr(preg_replace('/[^A-Za-z]/', '', $kata), 0, 1))
                        ->implode(''));
                };
            @endphp

            <div id="tim" class="animate-fade-up scroll-mt-24 bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-danger-100 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-danger-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-neutral-900">Tim Pengembang</h2>
                            <p class="text-xs text-neutral-500">10 anggota &middot; 3 pembimbing &middot; PPG UNM 2026</p>
                        </div>
                    </div>
                </div>
                <div class="px-4 sm:px-6 py-6 space-y-7">

                    {{-- ============ Pembimbing ============ --}}
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-3">Pembimbing Projek</p>
                        <div class="grid sm:grid-cols-2 gap-3.5">
                            {{-- Dosen Pengampu --}}
                            <div class="group flex items-center gap-4 bg-neutral-50 border border-primary-100 rounded-2xl p-4 hover:bg-neutral-surface hover:border-primary-300 hover:shadow-lg transition-all duration-300">
                                <div class="relative shrink-0">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-primary-600 text-white text-xl sm:text-2xl font-extrabold flex items-center justify-center shadow-md ring-4 ring-white">
                                        <span>SY</span>
                                    </div>
                                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow-sm">
                                        <span class="w-3 h-3 bg-success-500 rounded-full"></span>
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-primary-100 text-primary-700">Dosen Pengampu</span>
                                    <p class="mt-1.5 text-base sm:text-lg font-bold text-neutral-900 truncate">Sufitryono, S.Pd., M.Pd.</p>
                                    <p class="text-sm text-neutral-600 mt-0.5">PPG &middot; Universitas Negeri Makassar</p>
                                </div>
                            </div>

                            {{-- Guru Pamong --}}
                            <div class="group flex items-center gap-4 bg-neutral-50 border border-success-100 rounded-2xl p-4 hover:bg-neutral-surface hover:border-success-500 hover:shadow-lg transition-all duration-300">
                                <div class="relative shrink-0">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-success-600 text-white text-xl sm:text-2xl font-extrabold flex items-center justify-center shadow-md ring-4 ring-white">
                                        <span>FS</span>
                                    </div>
                                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow-sm">
                                        <span class="w-3 h-3 bg-success-500 rounded-full"></span>
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-success-100 text-success-700">Guru Pamong</span>
                                    <p class="mt-1.5 text-base sm:text-lg font-bold text-neutral-900 truncate">Fanna Sriwati, S.Pd.</p>
                                    <p class="text-sm text-neutral-600 mt-0.5">UPT SPF SMP Negeri 40 Makassar</p>
                                </div>
                            </div>
                        </div>

                        {{-- Kepala Sekolah --}}
                        <div class="group flex items-center justify-between gap-4 bg-neutral-50 border border-warning-100 rounded-2xl p-4 mt-3.5 hover:bg-neutral-surface hover:border-warning-500 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="relative shrink-0">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-warning-600 text-white text-lg sm:text-xl font-extrabold flex items-center justify-center shadow-md ring-4 ring-white">
                                        <span>NR</span>
                                    </div>
                                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow-sm">
                                        <span class="w-3 h-3 bg-warning-500 rounded-full"></span>
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-warning-100 text-warning-700">Kepala Sekolah</span>
                                    <p class="mt-1.5 text-base sm:text-lg font-bold text-neutral-900 truncate">Nurhadiawati, S.Pd., M.Pd.</p>
                                    <p class="text-sm text-neutral-600 mt-0.5">UPT SPF SMP Negeri 40 Makassar</p>
                                </div>
                            </div>
                            <span class="shrink-0 hidden md:inline-flex items-center gap-1.5 text-[11px] font-semibold text-warning-700 bg-warning-100 border border-warning-500/20 rounded-full px-3 py-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                </svg>
                                Adiwiyata Mandiri
                            </span>
                        </div>
                    </div>

                    {{-- ============ Kelompok Tim ============ --}}
                    <div class="space-y-5">
                        {{-- SMPN 40 --}}
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <p class="text-xs font-bold uppercase tracking-wider text-neutral-400">Kelompok SMPN 40 Makassar</p>

                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
                                @foreach ($timSmp40 as $i => $nama)
                                    <div class="group flex flex-col items-center text-center bg-neutral-50 border border-transparent rounded-2xl px-3 py-5 hover:bg-neutral-surface hover:border-primary-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                                        <div class="w-16 h-16 rounded-2xl {{ $warnaAv[$i % count($warnaAv)] }} text-white text-lg font-extrabold flex items-center justify-center shadow-md ring-4 ring-white group-hover:scale-105 transition-transform duration-300">
                                            <span>{{ $buatInisial($nama) }}</span>
                                        </div>
                                        <p class="mt-3 text-sm sm:text-base font-bold text-neutral-800 leading-snug">{{ $nama }}</p>
                                        <span class="mt-1.5 inline-flex items-center gap-1 text-[10px] font-semibold uppercase tracking-wider text-neutral-400">

                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Quote / Ajakan -->
            <div class="relative bg-neutral-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-600/30 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <p class="text-lg sm:text-xl font-bold leading-relaxed">
                        &ldquo;Presensi yang <span class="text-primary-400">akurat</span>,
                        refleksi yang <span class="text-primary-400">bermakna</span>.&rdquo;
                    </p>
                    <p class="mt-2 text-sm text-neutral-300">SIPERFLEX &mdash; Sistem Informasi Presensi dan Refleksi Fleksibel</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center py-2">
                <p class="text-xs text-neutral-400">&copy; {{ date('Y') }} SIPERFLEX &mdash; Presensi Akurat, Refleksi Bermakna</p>
            </div>
        </section>
    </main>

</body>
</html>
