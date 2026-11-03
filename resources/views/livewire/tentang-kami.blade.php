<div>
    {{-- Page Header --}}
    <x-slot name="header">Tentang Kami</x-slot>
    <x-slot name="title">Tentang Kami - SIPERFLEX</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Hero Card --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-primary-800 via-primary-700 to-primary-500 rounded-2xl shadow-xl text-white">
            <div class="absolute w-56 h-56 bg-primary-400 -top-12 -left-12 rounded-full opacity-40 blur-3xl pointer-events-none"></div>
            <div class="absolute w-64 h-64 bg-info-500 bottom-0 -right-12 rounded-full opacity-30 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 px-6 py-8 md:px-10 md:py-10 flex flex-col sm:flex-row items-center gap-6">
                <div class="w-20 h-20 bg-white/10 border border-white/20 rounded-2xl flex items-center justify-center shrink-0 backdrop-blur-sm">
                    <img src="{{ asset('logo-transparan.png') }}" alt="Logo SIPERFLEX" class="w-12 h-12 object-contain">
                </div>
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold">Tentang SIPERFLEX</h1>
                    <p class="text-primary-100 text-sm mt-1.5 max-w-xl">
                        Sistem Informasi Presensi dan Refleksi Fleksibel untuk SMP Negeri 40 Makassar.
                    </p>
                </div>
            </div>
        </div>

        {{-- Tentang Sekolah --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
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
                <p class="text-neutral-600 text-sm leading-relaxed">SMP Negeri 40 Makassar, yang secara resmi bernama <strong>UPT SPF SMP Negeri 40 Makassar</strong>, adalah sekolah menengah pertama negeri di bawah naungan pemerintah daerah yang berlokasi di Kecamatan Rappocini, Kota Makassar, tepatnya di Jl. Aroepala. Sekolah ini terakreditasi <strong>B</strong>, menggunakan <strong>Kurikulum Merdeka</strong>, dan dipimpin oleh <strong>Nurhadiawati, S.Pd., M.Pd.</strong> selaku kepala sekolah. Berdasarkan data Kemendikdasmen, sekolah ini memiliki 48 guru dan sekitar 720 siswa dalam 24 rombongan belajar, serta fasilitas berupa 2 laboratorium dan 1 perpustakaan di atas lahan seluas 10.000 m². Sekolah ini dikenal sebagai sekolah <strong>Adiwiyata Mandiri</strong> di Sulawesi Selatan.</p>
                <div class="mt-5 grid sm:grid-cols-3 gap-3">
                    <div class="flex items-center gap-3 bg-success-50 border border-success-100 rounded-xl p-3">
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
                    <div class="flex items-center gap-3 bg-info-50 border border-info-100 rounded-xl p-3">
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
                    <div class="flex items-center gap-3 bg-warning-50 border border-warning-100 rounded-xl p-3">
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

        {{-- Apa Itu SIPERFLEX --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-info-50 to-white">
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
                <p class="text-neutral-600 text-sm leading-relaxed">Siperflex adalah <strong>Sistem Informasi Presensi Fleksibel Berbasis Digital</strong> yang dapat diakses oleh empat komponen pengguna, yaitu super admin, admin, guru, dan siswa. Aplikasi ini dirancang untuk mencatat dan memantau kehadiran secara digital sehingga proses pencatatan menjadi lebih praktis, terstruktur, dan mudah ditelusuri dibandingkan presensi manual.</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7a4 4 0 108 0 4 4 0 00-8 0z"></path>
                            </svg>
                        </div>
                        <p class="text-xs sm:text-sm font-semibold text-neutral-700">Admin Sekolah</p>
                    </div>
                    <div class="flex items-center gap-3 bg-neutral-50 border border-neutral-100 rounded-xl p-3">
                        <div class="w-9 h-9 rounded-lg bg-success-100 text-success-700 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7"></path>
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

        {{-- Latar Belakang --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-warning-50 to-white">
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
                <p class="text-neutral-600 text-sm leading-relaxed">Siperflex terealisasikan tahun 2026 dari sebuah projek kepemimpinan yang dikerjakan oleh mahasiswa PPL <strong>Program Profesi Guru (PPG) Universitas Negeri Makassar (UNM)</strong> di SMP Negeri 40 Makassar. Projek ini dikerjakan oleh kelompok mahasiswa yang berkolaborasi untuk mengatasi kendala pencatatan kehadiran yang masih dilakukan secara manual. Keberhasilan pengembangan projek ini tidak lepas dari bimbingan <strong>Pak Sufitryono, S.Pd., M.Pd.</strong> selaku dosen pengampu mata kuliah serta <strong>Fanna Sriwati, S.Pd.</strong> selaku guru pamong.</p>
            </div>
        </div>

        {{-- Visi & Misi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-success-50 to-white">
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
                        <p class="text-sm leading-relaxed">Menjadi sistem informasi presensi digital yang andal, mudah digunakan, dan transparan dalam mendukung terciptanya budaya disiplin serta tertib administrasi di lingkungan sekolah.</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-neutral-400">Misi</p>
                    <ol class="space-y-2">
                        @foreach ([
                            'Menyediakan sistem absensi digital yang praktis, cepat, dan mudah diakses.',
                            'Menggantikan pencatatan kehadiran manual dengan sistem yang lebih akurat, efisien, dan minim kesalahan.',
                            'Menyajikan data kehadiran secara real-time dan rapi sehingga mudah dipantau serta direkap oleh pihak yang berwenang.',
                            'Menerapkan pembagian hak akses sesuai peran pengguna untuk menjaga keamanan dan keteraturan data.',
                            'Mendorong kedisiplinan dan tanggung jawab seluruh warga sekolah melalui pemanfaatan teknologi digital.',
                        ] as $i => $teks)
                            <li class="flex items-start gap-3 bg-neutral-50 border border-neutral-100 rounded-xl p-3.5">
                                <span class="w-7 h-7 shrink-0 rounded-full bg-primary-600 text-white text-xs font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                                <p class="text-sm text-neutral-600 leading-relaxed">{{ $teks }}</p>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>

        {{-- Tim Pengembang --}}
        <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-neutral-100 bg-gradient-to-r from-danger-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-danger-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-neutral-900">Tim Pengembang</h2>
                        <p class="text-xs text-neutral-500">Dosen pembimbing &amp; guru pamong</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-6 space-y-6">

                {{-- Card pembimbing & guru pamong --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="relative bg-gradient-to-br from-primary-600 via-primary-500 to-info-500 rounded-2xl p-5 text-white shadow-md overflow-hidden">
                        <div class="absolute -top-8 -right-8 w-28 h-28 bg-white/10 rounded-full"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/25 flex items-center justify-center overflow-hidden shrink-0">
                                {{-- Foto: ganti dengan <img src="{{ asset('photos/sufitryono.jpg') }}" class="w-full h-full object-cover"> --}}
                                <span class="text-2xl font-extrabold">SY</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-primary-100">Dosen Pengampu</p>
                                <p class="text-base font-bold mt-0.5 truncate">Sufitryono, S.Pd., M.Pd.</p>
                                <p class="text-xs text-primary-100/80">Program Profesi Guru &middot; UNM</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative bg-gradient-to-br from-success-600 via-success-500 to-warning-500 rounded-2xl p-5 text-white shadow-md overflow-hidden">
                        <div class="absolute -top-8 -right-8 w-28 h-28 bg-white/10 rounded-full"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-16 h-16 rounded-2xl bg-white/15 border border-white/25 flex items-center justify-center overflow-hidden shrink-0">
                                {{-- Foto: ganti dengan <img src="{{ asset('photos/fanna-sriwati.jpg') }}" class="w-full h-full object-cover"> --}}
                                <span class="text-2xl font-extrabold">FS</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-success-100">Guru Pamong</p>
                                <p class="text-base font-bold mt-0.5 truncate">Fanna Sriwati, S.Pd.</p>
                                <p class="text-xs text-success-100/80">SMP Negeri 40 Makassar</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kepala Sekolah --}}
                <div class="flex items-center justify-between gap-4 bg-neutral-50 border border-neutral-200 rounded-2xl p-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-warning-100 text-warning-700 border border-warning-200 flex items-center justify-center overflow-hidden shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-neutral-800 truncate">Nurhadiawati, S.Pd., M.Pd.</p>
                            <p class="text-xs text-neutral-500">Kepala Sekolah &middot; SMP Negeri 40 Makassar</p>
                        </div>
                    </div>
                    <span class="shrink-0 inline-flex items-center gap-1.5 text-[11px] font-semibold text-warning-700  border border-warning-200 rounded-full px-3 py-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                        </svg>
                        Adiwiyata Mandiri
                    </span>
                </div>

                {{-- Kelompok mahasiswa --}}
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-3">Kelompok SMPN 40 Makassar</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach (['Via Ahsani', 'Abd. Rahman', 'Muhammad Alqadri', 'Haldiyanto', 'Muh. Nur Abriansyah'] as $nama)
                                @php
                                    $inisial = strtoupper(collect(explode(' ', $nama))->take(2)->map(function ($kata) {
                                        return mb_substr(preg_replace('/[^A-Za-z]/', '', $kata), 0, 1);
                                    })->implode(''));
                                @endphp
                                <div class="group flex items-center gap-3 bg-neutral-50 border border-neutral-200 hover:border-primary-300 hover:bg-primary-50 rounded-xl p-3 transition-all hover:shadow-sm">
                                    <div class="w-10 h-10 rounded-full bg-primary-600 text-white text-xs font-bold flex items-center justify-center shrink-0">
                                        <span>{{ $inisial }}</span>
                                    </div>
                                    <p class="text-xs sm:text-sm font-semibold text-neutral-700 leading-snug">{{ $nama }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center py-4">
            <p class="text-xs text-neutral-400">&copy; {{ date('Y') }} SIPERFLEX &mdash; Presensi Akurat, Refleksi Bermakna</p>
        </div>

    </div>
</div>
