<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-xl shadow-sm border-l-4 border-primary-500">
        <div>
            <h2 class="text-2xl font-bold text-neutral-800">Dashboard Guru</h2>
            <p class="text-neutral-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
        <div class="mt-4 sm:mt-0 text-right">
            <p class="text-sm font-medium text-neutral-500">{{ \Carbon\Carbon::parse($filterDate)->translatedFormat('l, d F Y') }}</p>
            @if($classRoom)
                <span class="inline-block bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full mt-1 font-semibold">Kelas: {{ $classRoom->class_name }}</span>
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

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- FILTERS -->
            <div class="p-4 border-b border-neutral-200 bg-neutral-50 flex flex-col md:flex-row justify-between items-center gap-4">
                <h3 class="text-lg font-bold text-neutral-800">Rekap Absensi</h3>
                <div class="flex flex-wrap items-center justify-end gap-3 w-full md:w-auto">
                    @if(count($availableClasses) > 1)
                        <select wire:model.live="filterClassId" class="rounded-md border border-neutral-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 font-medium">
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
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50 text-neutral-600 text-sm uppercase tracking-wider border-b border-neutral-200">
                            <th class="p-4 font-semibold w-1/4">Siswa</th>
                            <th class="p-4 font-semibold text-center w-1/6">Status & Waktu</th>
                            <th class="p-4 font-semibold w-1/4">Jurnal & Lokasi</th>
                            <th class="p-4 font-semibold text-center w-1/6">Bukti Absen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @forelse($students as $student)
                            @php
                                $attendance = $attendances->get($student->id);
                                $avatarUrl = $student->profile_photo_path 
                                    ? '/storage/' . $student->profile_photo_path 
                                    : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&color=7F9CF5&background=EBF4FF';
                            @endphp
                            <tr class="hover:bg-neutral-50 transition-colors">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $avatarUrl }}" alt="{{ $student->name }}" class="w-10 h-10 rounded-full object-cover border border-neutral-200">
                                        <div>
                                            <div class="font-bold text-neutral-800">{{ $student->name }}</div>
                                            <div class="text-xs text-neutral-500">NIS: {{ $student->nis ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center align-top">
                                    @if($attendance)
                                        <div class="mb-1">
                                            @switch($attendance->status)
                                                @case('hadir')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">HADIR</span>
                                                    @break
                                                @case('terlambat')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">TERLAMBAT</span>
                                                    @break
                                                @case('sakit')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">SAKIT</span>
                                                    @break
                                                @case('izin')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">IZIN</span>
                                                    @break
                                            @endswitch
                                        </div>
                                        <div class="text-xs font-semibold text-neutral-600">
                                            {{ \Carbon\Carbon::parse($attendance->time)->format('H:i') }} WIB
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-600">Belum Absen</span>
                                    @endif
                                </td>
                                <td class="p-4 align-top">
                                    @if($attendance)
                                        <div class="mb-2">
                                            <span class="text-xs text-neutral-400 font-medium">LOKASI:</span>
                                            @if($attendance->latitude && $attendance->longitude)
                                                <div class="text-xs text-blue-600 truncate max-w-[200px]" title="{{ $attendance->latitude }}, {{ $attendance->longitude }}">
                                                    <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" target="_blank" class="hover:underline flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        Lihat Peta
                                                    </a>
                                                </div>
                                            @else
                                                <div class="text-xs text-neutral-500">-</div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-xs text-neutral-400 font-medium block">REFLEKSI:</span>
                                            <div class="flex items-start gap-2 mt-1">
                                                @if($attendance->mood)
                                                    <span title="Mood: {{ ucfirst($attendance->mood) }}" class="text-lg leading-none mt-0.5">
                                                        @switch($attendance->mood)
                                                            @case('senang') 😊 @break
                                                            @case('sedih') 😢 @break
                                                            @case('lelah') 😩 @break
                                                            @case('semangat') 🔥 @break
                                                            @case('netral') 😐 @break
                                                        @endswitch
                                                    </span>
                                                @endif
                                                <p class="text-sm text-neutral-700 italic">"{{ $attendance->reflection_text ?? '-' }}"</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-neutral-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center align-top">
                                    @if($attendance && $attendance->photo_path)
                                        <a href="/storage/{{ $attendance->photo_path }}" target="_blank" title="Lihat Foto Absen">
                                            <img src="/storage/{{ $attendance->photo_path }}" alt="Bukti Absen" class="w-16 h-16 object-cover rounded-lg border border-neutral-300 shadow-sm mx-auto hover:opacity-80 transition-opacity">
                                        </a>
                                    @elseif($attendance)
                                        <span class="text-xs text-neutral-400 italic">Tanpa Foto</span>
                                    @else
                                        <span class="text-neutral-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-neutral-500">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
</div>
