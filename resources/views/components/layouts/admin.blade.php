<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard - SIPERFLEX' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo-transparan.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo-transparan.png') }}">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#1D4ED8">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="{{ $title ?? 'Dashboard - SIPERFLEX' }}">
    <meta property="og:description" content="Sistem Informasi Presensi dan Refleksi Fleksibel untuk Sekolah.">
    <meta property="og:image" content="{{ asset('logo-login.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Optional: Alpine.js for dropdowns/sidebar toggle if Livewire doesn't handle it entirely -->
</head>

<body class="bg-neutral-bg text-neutral-900 font-sans antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <aside class="w-64 bg-primary-700 text-white flex flex-col hidden md:flex shrink-0 transition-all duration-300">
        <div class="h-16 flex items-center justify-left border-b  border-primary-600 px-4 py-2">
            <img src="{{ asset('logo.webp') }}" alt="SIPERFLEX Logo" class="rounded-md max-h-10 w-auto object-contain">
            <h1 class="text-2xl px-2">SIPERFLEX</h1>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @php
                $role = auth()->user()->role;
            @endphp

            @if ($role === 'super_admin')
                <a href="{{ route('superadmin.dashboard') }}"
                    class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('superadmin.dashboard') ? 'bg-primary-800' : 'hover:bg-primary-600' }}">Dashboard</a>
                <!-- Add more super admin links here -->
            @endif

            @if ($role === 'admin_sekolah')
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Manajemen
                    Pengguna</a>
                <a href="{{ route('admin.kelas.index') }}"
                    class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('admin.kelas.*') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Manajemen
                    Kelas</a>
                <a href="{{ route('admin.approval.index') }}"
                    class="block px-4 py-2 rounded transition-colors flex justify-between items-center {{ request()->routeIs('admin.approval.*') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">
                    <span>Persetujuan Data</span>
                    @php
                        $pendingCount = \App\Models\StudentChangeRequest::where('status', 'pending')
                            ->whereHas('student', function ($query) {
                                $query->where('school_id', auth()->user()->school_id);
                            })
                            ->count();
                    @endphp
                    @if ($pendingCount > 0)
                        <span
                            class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            @endif

            @if ($role === 'guru')
                <a href="{{ route('guru.dashboard') }}"
                    class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('guru.dashboard') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Monitoring
                    Kehadiran</a>
                <a href="{{ route('guru.siswa.index') }}"
                    class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('guru.siswa.*') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Manajemen
                    Siswa</a>
            @endif

            @if ($role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}"
                    class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-primary-800' : 'hover:bg-primary-600' }}">Dashboard</a>
                <!-- Add more siswa links here -->
            @endif
        </nav>

        <div class="p-4 border-t border-primary-600">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-100 font-medium rounded hover:bg-red-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Keluar / Logout
                </button>
            </form>
        </div>

        {{-- Tentang Kami Button --}}
        <div class="p-4 border-t border-primary-600">
            <a href="{{ route('tentang.kami') }}"
                class="w-full flex items-center gap-2 px-3 py-2 text-sm text-primary-200 font-medium rounded hover:bg-primary-600 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Tentang Kami
            </a>
        </div>

        <div class="p-4 border-t border-primary-600 text-sm text-primary-200">
            &copy; {{ date('Y') }} Siperflex
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full">
        <!-- Topbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 shrink-0">
            <div class="flex items-center gap-3">
                <!-- Tampil di Mobile/Tablet jika sidebar tersembunyi -->
                <img src="{{ asset('logo.webp') }}" alt="SIPERFLEX Logo" class="h-8 md:hidden">
                <!-- Judul Halaman (Sembunyikan di layar sangat kecil agar tidak sempit) -->
                <h2 class="text-xl font-semibold text-neutral-800 hidden sm:block">
                    {{ $header ?? 'Dashboard' }}
                </h2>
            </div>

            <div class="flex items-center space-x-3 md:space-x-4">
                <span class="text-sm font-medium text-neutral-700 hidden sm:block">{{ auth()->user()->name }}
                    ({{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }})</span>
                <span
                    class="text-sm font-medium text-neutral-700 block sm:hidden">{{ substr(auth()->user()->name, 0, 15) }}{{ strlen(auth()->user()->name) > 15 ? '...' : '' }}</span>

                <!-- Logout Button for Mobile -->
                <form method="POST" action="{{ route('logout') }}" class="block md:hidden flex items-center">
                    @csrf
                    <button type="submit"
                        class="text-red-500 hover:text-red-700 p-1.5 -mr-1.5 rounded-full hover:bg-red-50 transition-colors"
                        title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-neutral-100 p-6 pb-24 md:pb-6">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-neutral-200 shadow-[0_-4px_15px_rgba(0,0,0,0.05)] pb-safe">
        <div class="flex justify-around items-center h-16">
            @php $role = auth()->user()->role; @endphp

            @if ($role === 'super_admin')
                <a href="{{ route('superadmin.dashboard') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('superadmin.dashboard') ? 'text-primary-600' : 'text-neutral-400 hover:text-neutral-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="text-[10px] font-medium">Dashboard</span>
                </a>
            @endif

            @if ($role === 'admin_sekolah')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('admin.dashboard') ? 'text-primary-600' : 'text-neutral-400 hover:text-neutral-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-[10px] font-medium">Pengguna</span>
                </a>
                <a href="{{ route('admin.kelas.index') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('admin.kelas.*') ? 'text-primary-600' : 'text-neutral-400 hover:text-neutral-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <span class="text-[10px] font-medium">Kelas</span>
                </a>
                <a href="{{ route('admin.approval.index') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 relative {{ request()->routeIs('admin.approval.*') ? 'text-primary-600' : 'text-neutral-400 hover:text-neutral-600' }}">
                    <div class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @php
                            $pendingCount = \App\Models\StudentChangeRequest::where('status', 'pending')
                                ->whereHas('student', function ($query) {
                                    $query->where('school_id', auth()->user()->school_id);
                                })
                                ->count();
                        @endphp
                        @if ($pendingCount > 0)
                            <span
                                class="absolute -top-1 -right-2 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full min-w-[16px] text-center">{{ $pendingCount }}</span>
                        @endif
                    </div>
                    <span class="text-[10px] font-medium">Persetujuan</span>
                </a>
            @endif

            @if ($role === 'guru')
                <a href="{{ route('guru.dashboard') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('guru.dashboard') ? 'text-primary-600' : 'text-neutral-400 hover:text-neutral-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="text-[10px] font-medium">Kehadiran</span>
                </a>
                <a href="{{ route('guru.siswa.index') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('guru.siswa.*') ? 'text-primary-600' : 'text-neutral-400 hover:text-neutral-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-[10px] font-medium">Siswa</span>
                </a>
            @endif

            @if ($role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('siswa.dashboard') ? 'text-primary-600' : 'text-neutral-400 hover:text-neutral-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="text-[10px] font-medium">Dashboard</span>
                </a>
            @endif

            

        </div>
    </nav>

    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                        // Eagerly cache current dashboard view
                        if ('caches' in window) {
                            caches.open('siperflex-cache-v6').then(cache => {
                                cache.add(window.location.pathname).catch(e => console.warn('Cache add error:', e));
                            });
                        }
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
</body>

</html>
