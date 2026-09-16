<div class="space-y-6">
    <!-- Modern Header Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-primary-400 opacity-20 blur-xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Dashboard Guru</h2>
            <p class="text-primary-100 font-medium mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
        
        <div class="relative z-10 w-full sm:w-auto flex flex-col sm:items-end text-left sm:text-right mt-4 sm:mt-0">
            <p class="text-sm font-semibold text-primary-100">{{ \Carbon\Carbon::parse($filterDate)->translatedFormat('l, d F Y') }}</p>
            @if($classRoom)
                <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-md text-white text-sm font-semibold px-3 py-1.5 rounded-lg border border-white/10 mt-2 shadow-inner">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Kelas: {{ $classRoom->class_name }}
                </span>
            @endif
        </div>
    </div>

    @if(!$classRoom)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-4 rounded-lg shadow-sm text-center">
            <p class="font-medium">Anda belum ditugaskan sebagai wali kelas untuk kelas mana pun.</p>
        </div>
    @else
        <!-- STATS CARDS -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 text-center hover:shadow-md transition-shadow cursor-pointer" wire:click="$set('filterStatus', '')" @if($filterStatus === '') style="border-color: #2563EB" @endif>
                <div class="text-2xl font-bold text-neutral-800">{{ count($students) }}</div>
                <div class="text-xs font-medium text-neutral-500 uppercase mt-1">Total Siswa</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 text-center hover:shadow-md transition-shadow cursor-pointer" wire:click="$set('filterStatus', 'hadir')" @if($filterStatus === 'hadir') style="border-color: #10B981" @endif>
                <div class="text-2xl font-bold text-green-600">{{ $stats['hadir'] }}</div>
                <div class="text-xs font-medium text-neutral-500 uppercase mt-1">Hadir</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 text-center hover:shadow-md transition-shadow cursor-pointer" wire:click="$set('filterStatus', 'terlambat')" @if($filterStatus === 'terlambat') style="border-color: #F59E0B" @endif>
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['terlambat'] }}</div>
                <div class="text-xs font-medium text-neutral-500 uppercase mt-1">Terlambat</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 text-center hover:shadow-md transition-shadow cursor-pointer" wire:click="$set('filterStatus', 'izin')" @if($filterStatus === 'izin') style="border-color: #8B5CF6" @endif>
                <div class="text-2xl font-bold text-blue-600">{{ $stats['izin'] + $stats['sakit'] }}</div>
                <div class="text-xs font-medium text-neutral-500 uppercase mt-1">Sakit & Izin</div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-neutral-100 text-center hover:shadow-md transition-shadow cursor-pointer" wire:click="$set('filterStatus', 'belum_absen')" @if($filterStatus === 'belum_absen') style="border-color: #EF4444" @endif>
                <div class="text-2xl font-bold text-red-600">{{ $stats['belum_absen'] }}</div>
                <div class="text-xs font-medium text-neutral-500 uppercase mt-1">Belum Absen</div>
            </div>
        </div>

        <div class="md:bg-white md:rounded-xl md:shadow-sm md:overflow-hidden">
            <!-- FILTERS -->
            <div class="p-4 md:p-4 bg-white md:bg-neutral-50 rounded-2xl md:rounded-none shadow-sm md:shadow-none md:border-b md:border-neutral-200 flex flex-col md:flex-row justify-between items-center gap-4 mb-6 md:mb-0">
                <h3 class="text-lg font-bold text-neutral-800 shrink-0">Rekap Absensi</h3>
                <div class="flex flex-col sm:flex-row flex-wrap items-center justify-end gap-3 w-full md:w-auto">
                    <div class="relative w-full sm:w-48 shrink-0">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari siswa..." class="w-full pl-9 pr-3 py-1.5 bg-white border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 font-medium">
                    </div>
                    @if(count($availableClasses) > 1)
                        <select wire:model.live="filterClassId" class="w-full sm:w-auto rounded-lg border border-neutral-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 font-medium">
                            @foreach($availableClasses as $ac)
                                <option value="{{ $ac->id }}">{{ $ac->class_name }}</option>
                            @endforeach
                        </select>
                    @endif
                    
                    <input type="date" wire:model.live="filterDate" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <select wire:model.live="filterStatus" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="belum_absen">Belum Absen</option>
                    </select>
                    
                    <div class="flex items-center space-x-2 border-l border-neutral-300 pl-3">
                        <button wire:click="exportCsv" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium shadow-sm transition-colors flex items-center gap-1" title="Export ke CSV">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            CSV
                        </button>
                        <button wire:click="exportPdf" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium shadow-sm transition-colors flex items-center gap-1" title="Export ke PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            PDF
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile View (Cards) -->
            <div class="block md:hidden space-y-4">
                @forelse($students as $student)
                    @php
                        $attendance = $attendances->get($student->id);
                        $avatarUrl = $student->profile_photo_path 
                            ? '/storage/' . $student->profile_photo_path 
                            : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&color=7F9CF5&background=EBF4FF';
                    @endphp
                    <div class="bg-white rounded-2xl border border-neutral-100 p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <!-- Removed left border indicator, relying on modern card design and badges -->
                        
                        <div class="flex justify-between items-start mb-4 border-b border-neutral-50 pb-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $avatarUrl }}" alt="{{ $student->name }}" class="w-10 h-10 rounded-full object-cover border border-neutral-200">
                                <div>
                                    <h4 class="font-bold text-neutral-800 text-sm">{{ $student->name }}</h4>
                                    <div class="text-xs text-neutral-500 mt-0.5">NIS: {{ $student->nis ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($attendance)
                                    <div class="mb-1">
                                        @switch($attendance->status)
                                            @case('hadir')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">HADIR</span>
                                                @break
                                            @case('terlambat')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">TERLAMBAT</span>
                                                @break
                                            @case('sakit')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">SAKIT</span>
                                                @break
                                            @case('izin')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">IZIN</span>
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="text-xs font-bold text-neutral-700">
                                        {{ \Carbon\Carbon::parse($attendance->time)->format('H:i') }} WIB
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-neutral-100 text-neutral-600 border border-neutral-200">BELUM ABSEN</span>
                                @endif
                            </div>
                        </div>

                        @if($attendance)
                            <div class="bg-neutral-50 rounded-lg p-3 space-y-2 border border-neutral-100 mb-3">
                                <div>
                                    <span class="text-xs text-neutral-400 font-semibold block mb-0.5">REFLEKSI:</span>
                                    <div class="flex items-start gap-2">
                                        @if($attendance->mood)
                                            <span title="Mood: {{ ucfirst($attendance->mood) }}" class="text-base leading-none">
                                                @switch($attendance->mood)
                                                    @case('senang') 😊 @break
                                                    @case('sedih') 😢 @break
                                                    @case('lelah') 😩 @break
                                                    @case('semangat') 🔥 @break
                                                    @case('netral') 😐 @break
                                                @endswitch
                                            </span>
                                        @endif
                                        <p class="text-xs text-neutral-700 italic">"{{ $attendance->reflection_text ?? '-' }}"</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-neutral-200/50 mt-2">
                                    <div class="text-xs">
                                        <span class="text-neutral-400 font-semibold">LOKASI:</span>
                                        @if($attendance->latitude && $attendance->longitude)
                                            <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 mt-0.5">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                Peta
                                            </a>
                                        @else
                                            <span class="text-neutral-500 block">-</span>
                                        @endif
                                    </div>
                                    @if($attendance->photo_path)
                                        <a href="/storage/{{ $attendance->photo_path }}" target="_blank" class="flex items-center gap-1 text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-1 rounded border border-primary-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Lihat Bukti
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center p-4 bg-neutral-50 rounded-lg border border-neutral-100 border-dashed">
                                <span class="text-xs text-neutral-400 font-medium">Belum ada data absensi hari ini.</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8 px-4 bg-neutral-50 rounded-xl border border-neutral-200">
                        <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <p class="text-neutral-500 font-medium">Tidak ada siswa yang cocok dengan filter saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop View (Table) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                            <th class="p-5 font-bold w-1/4">Siswa</th>
                            <th class="p-5 font-bold text-center w-1/6">Status & Waktu</th>
                            <th class="p-5 font-bold w-1/3">Jurnal & Lokasi</th>
                            <th class="p-5 font-bold text-center w-1/6">Bukti Absen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($students as $student)
                            @php
                                $attendance = $attendances->get($student->id);
                                $avatarUrl = $student->profile_photo_path 
                                    ? '/storage/' . $student->profile_photo_path 
                                    : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&color=7F9CF5&background=EBF4FF';
                            @endphp
                            <tr class="hover:bg-primary-50/50 transition-colors group">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $avatarUrl }}" alt="{{ $student->name }}" class="w-10 h-10 rounded-full object-cover border border-neutral-200 shadow-sm group-hover:border-primary-300 transition-colors">
                                        <div>
                                            <div class="font-bold text-neutral-800 text-sm group-hover:text-primary-700 transition-colors">{{ $student->name }}</div>
                                            <div class="text-xs text-neutral-500 mt-0.5">NIS: <span class="font-medium text-neutral-600">{{ $student->nis ?? '-' }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center align-middle">
                                    @if($attendance)
                                        <div class="mb-1.5 flex justify-center">
                                            @switch($attendance->status)
                                                @case('hadir')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm">HADIR</span>
                                                    @break
                                                @case('terlambat')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 shadow-sm">TERLAMBAT</span>
                                                    @break
                                                @case('sakit')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200 shadow-sm">SAKIT</span>
                                                    @break
                                                @case('izin')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">IZIN</span>
                                                    @break
                                            @endswitch
                                        </div>
                                        <div class="text-sm font-bold text-neutral-800 flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($attendance->time)->format('H:i') }}
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold bg-neutral-100 text-neutral-500 border border-neutral-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Belum Absen
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5 align-top">
                                    @if($attendance)
                                        <div class="bg-white border border-neutral-200 rounded-lg p-3 shadow-sm group-hover:border-primary-200 transition-colors">
                                            <div class="mb-2 pb-2 border-b border-neutral-100 flex items-start gap-2">
                                                <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider w-16 mt-0.5">LOKASI</span>
                                                @if($attendance->latitude && $attendance->longitude)
                                                    <div class="text-xs text-blue-600 truncate max-w-[200px]" title="{{ $attendance->latitude }}, {{ $attendance->longitude }}">
                                                        <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" target="_blank" class="hover:underline flex items-center gap-1 font-medium bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                            Lihat Peta
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-neutral-500 font-medium">-</span>
                                                @endif
                                            </div>
                                            <div class="flex items-start gap-2">
                                                <span class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider w-16 mt-1">REFLEKSI</span>
                                                <div class="flex-1 flex items-start gap-2">
                                                    @if($attendance->mood)
                                                        <span title="Mood: {{ ucfirst($attendance->mood) }}" class="text-lg leading-none">
                                                            @switch($attendance->mood)
                                                                @case('senang') 😊 @break
                                                                @case('sedih') 😢 @break
                                                                @case('lelah') 😩 @break
                                                                @case('semangat') 🔥 @break
                                                                @case('netral') 😐 @break
                                                            @endswitch
                                                        </span>
                                                    @endif
                                                    <p class="text-sm text-neutral-700 italic font-medium leading-tight mt-0.5">"{{ $attendance->reflection_text ?? '-' }}"</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-neutral-400 h-full">
                                            <div class="w-full h-px bg-neutral-200 border-dashed border-b flex-1"></div>
                                            <span class="text-xs font-medium uppercase tracking-wider">Menunggu Data</span>
                                            <div class="w-full h-px bg-neutral-200 border-dashed border-b flex-1"></div>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-5 text-center align-middle">
                                    @if($attendance && $attendance->photo_path)
                                        <a href="/storage/{{ $attendance->photo_path }}" target="_blank" title="Lihat Foto Absen" class="inline-block relative group/img">
                                            <img src="/storage/{{ $attendance->photo_path }}" alt="Bukti Absen" class="w-16 h-16 object-cover rounded-xl border-2 border-neutral-200 shadow-sm mx-auto group-hover/img:border-primary-400 transition-all">
                                            <div class="absolute inset-0 bg-black/50 rounded-xl opacity-0 group-hover/img:opacity-100 flex items-center justify-center transition-opacity">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </div>
                                        </a>
                                    @elseif($attendance)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-neutral-50 text-[10px] font-bold text-neutral-500 uppercase tracking-wider border border-neutral-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Tanpa Foto
                                        </span>
                                    @else
                                        <span class="text-neutral-300 font-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-10 text-center text-neutral-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p class="font-bold text-lg text-neutral-700">Tidak ada data</p>
                                        <p class="text-sm mt-1 text-neutral-500">Tidak ada siswa yang cocok dengan filter saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
</div>
