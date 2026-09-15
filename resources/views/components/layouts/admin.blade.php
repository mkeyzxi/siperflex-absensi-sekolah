<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard - SIPERFLEX' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Optional: Alpine.js for dropdowns/sidebar toggle if Livewire doesn't handle it entirely -->
</head>
<body class="bg-neutral-bg text-neutral-900 font-sans antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-primary-700 text-white flex flex-col hidden md:flex transition-all duration-300">
        <div class="h-16 flex items-center justify-center border-b border-primary-600 font-bold text-xl tracking-wider">
            SIPERFLEX
        </div>
        
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @php
                $role = auth()->user()->role;
            @endphp

            @if($role === 'super_admin')
                <a href="{{ route('superadmin.dashboard') }}" class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('superadmin.dashboard') ? 'bg-primary-800' : 'hover:bg-primary-600' }}">Dashboard</a>
                <!-- Add more super admin links here -->
            @endif

            @if($role === 'admin_sekolah')
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Manajemen Pengguna</a>
                <a href="{{ route('admin.kelas.index') }}" class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('admin.kelas.*') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Manajemen Kelas</a>
                <a href="{{ route('admin.approval.index') }}" class="block px-4 py-2 rounded transition-colors flex justify-between items-center {{ request()->routeIs('admin.approval.*') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">
                    <span>Persetujuan Data</span>
                    @php
                        $pendingCount = \App\Models\StudentChangeRequest::where('status', 'pending')
                            ->whereHas('student', function ($query) {
                                $query->where('school_id', auth()->user()->school_id);
                            })->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            @endif

            @if($role === 'guru')
                <a href="{{ route('guru.dashboard') }}" class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('guru.dashboard') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Monitoring Kehadiran</a>
                <a href="{{ route('guru.siswa.index') }}" class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('guru.siswa.*') ? 'bg-primary-800 font-medium shadow-sm' : 'hover:bg-primary-600' }}">Manajemen Siswa</a>
            @endif

            @if($role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}" class="block px-4 py-2 rounded transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-primary-800' : 'hover:bg-primary-600' }}">Dashboard</a>
                <!-- Add more siswa links here -->
            @endif
        </nav>
        
        <div class="p-4 border-t border-primary-600">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-100 font-medium rounded hover:bg-red-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar / Logout
                </button>
            </form>
        </div>
        
        <div class="p-4 border-t border-primary-600 text-sm text-primary-200">
            &copy; {{ date('Y') }} Siperflex
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
            <div class="flex items-center">
                <button class="md:hidden text-neutral-500 hover:text-neutral-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h2 class="ml-4 text-xl font-semibold text-neutral-800 hidden sm:block">
                    {{ $header ?? 'Dashboard' }}
                </h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-neutral-700">{{ auth()->user()->name }} ({{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }})</span>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-neutral-100 p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
