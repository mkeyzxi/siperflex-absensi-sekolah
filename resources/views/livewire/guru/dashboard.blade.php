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
                            <th class="p-4 font-semibold">Nama Siswa</th>
                            <th class="p-4 font-semibold text-center">Status & Waktu</th>
                            <th class="p-4 font-semibold">Mood</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @forelse($students as $student)
                            @php
                                $attendance = $attendances->get($student->id);
                            @endphp
                            <tr class="hover:bg-neutral-50 transition-colors">
                                <td class="p-4">
                                    <div class="font-medium text-neutral-800">{{ $student->name }}</div>
                                    <div class="text-xs text-neutral-500">NIS: {{ $student->nis ?? '-' }}</div>
                                </td>
                                <td class="p-4 text-center">
                                    @if($attendance)
                                        <div class="mb-1">
                                            @switch($attendance->status)
                                                @case('hadir')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                                                    @break
                                                @case('terlambat')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Terlambat</span>
                                                    @break
                                                @case('sakit')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Sakit</span>
                                                    @break
                                                @case('izin')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Izin</span>
                                                    @break
                                            @endswitch
                                        </div>
                                        <div class="text-xs text-neutral-500">
                                            {{ \Carbon\Carbon::parse($attendance->time)->format('H:i') }}
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-600">Belum Absen</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($attendance)
                                        <div class="flex items-center space-x-2">
                                            @if($attendance->mood)
                                                <span title="Mood: {{ ucfirst($attendance->mood) }}" class="text-2xl">
                                                    @switch($attendance->mood)
                                                        @case('senang') 😊 @break
                                                        @case('sedih') 😢 @break
                                                        @case('lelah') 😩 @break
                                                        @case('semangat') 🔥 @break
                                                        @case('netral') 😐 @break
                                                    @endswitch
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-neutral-400">-</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($attendance)
                                        @php
                                            $detailData = [
                                                'name' => $student->name,
                                                'nis' => $student->nis ?? '-',
                                                'status' => $attendance->status,
                                                'time' => \Carbon\Carbon::parse($attendance->time)->format('H:i'),
                                                'mood' => $attendance->mood,
                                                'reflection' => $attendance->reflection_text,
                                                'photo_url' => $attendance->photo_path ? Storage::url($attendance->photo_path) : null,
                                                'lat' => $attendance->latitude,
                                                'lng' => $attendance->longitude,
                                            ];
                                        @endphp
                                        <button onclick="showDetailModal({{ json_encode($detailData) }})" class="px-3 py-1.5 bg-primary-50 text-primary-600 hover:bg-primary-100 rounded-md text-sm font-medium transition-colors border border-primary-200">
                                            Lihat Detail
                                        </button>
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

    <!-- DETAIL MODAL -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" style="backdrop-filter: blur(4px);">
        <div class="bg-white rounded-xl shadow-2xl w-11/12 md:w-3/4 max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
            <div class="flex justify-between items-center p-4 border-b bg-neutral-50">
                <div>
                    <h3 class="text-lg font-bold text-neutral-800" id="modalStudentName">Detail Absensi</h3>
                    <p class="text-xs text-neutral-500" id="modalStudentNis">NIS: -</p>
                </div>
                <button onclick="closeDetailModal()" class="text-neutral-500 hover:text-red-500 bg-white rounded-full p-1 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Photo Section -->
                    <div class="bg-neutral-50 p-4 rounded-xl border border-neutral-200">
                        <h4 class="text-sm font-bold text-neutral-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            Foto Kehadiran
                        </h4>
                        <div id="modalPhotoContainer" class="w-full aspect-square bg-neutral-200 rounded-lg overflow-hidden flex items-center justify-center">
                            <span id="modalNoPhoto" class="text-neutral-500 text-sm hidden">Tidak ada foto</span>
                            <img id="modalPhoto" src="" class="w-full h-full object-cover hidden" alt="Foto Absen">
                        </div>
                    </div>
                    
                    <!-- Map Section -->
                    <div class="bg-neutral-50 p-4 rounded-xl border border-neutral-200">
                        <h4 class="text-sm font-bold text-neutral-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Lokasi Geografis (GPS)
                        </h4>
                        <div id="modalMapContainer" class="w-full aspect-square bg-neutral-200 rounded-lg relative overflow-hidden flex items-center justify-center z-0">
                            <span id="modalNoLocation" class="text-neutral-500 text-sm hidden">Lokasi tidak terdeteksi</span>
                        </div>
                    </div>
                </div>

                <div class="bg-primary-50 p-5 rounded-xl border border-primary-100">
                    <h4 class="text-sm font-bold text-primary-800 mb-4 uppercase tracking-wider">Informasi Jurnal / Refleksi</h4>
                    <div class="flex items-start space-x-4">
                        <div id="modalMoodIcon" class="text-5xl bg-white p-2 rounded-lg shadow-sm">😐</div>
                        <div class="flex-1">
                            <div class="mb-2 flex gap-2 items-center">
                                <span id="modalStatusBadge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"></span>
                                <span class="text-sm text-neutral-500">Pukul <span id="modalTime" class="font-bold text-neutral-700"></span></span>
                            </div>
                            <p id="modalReflection" class="text-neutral-700 italic border-l-4 border-primary-300 pl-4 py-1 text-sm bg-white p-3 rounded-r-lg shadow-sm w-full leading-relaxed min-h-[60px]"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border-t bg-neutral-50 text-right">
                <button onclick="closeDetailModal()" class="px-4 py-2 bg-neutral-200 text-neutral-800 font-medium rounded-lg hover:bg-neutral-300 transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        let map = null;
        let marker = null;

        function showDetailModal(data) {
            // Set Text Data
            document.getElementById('modalStudentName').innerText = 'Detail Absensi: ' + data.name;
            document.getElementById('modalStudentNis').innerText = 'NIS: ' + data.nis;
            document.getElementById('modalTime').innerText = data.time;
            
            const reflectionEl = document.getElementById('modalReflection');
            reflectionEl.innerText = data.reflection ? '"' + data.reflection + '"' : 'Tidak ada catatan refleksi.';
            
            // Set Mood
            let moodEmoji = '😐';
            switch(data.mood) {
                case 'senang': moodEmoji = '😊'; break;
                case 'sedih': moodEmoji = '😢'; break;
                case 'lelah': moodEmoji = '😩'; break;
                case 'semangat': moodEmoji = '🔥'; break;
            }
            document.getElementById('modalMoodIcon').innerText = moodEmoji;

            // Set Status Badge
            const badge = document.getElementById('modalStatusBadge');
            badge.innerText = data.status.toUpperCase();
            badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold text-white shadow-sm ';
            if(data.status === 'hadir') badge.className += 'bg-green-500';
            else if(data.status === 'terlambat') badge.className += 'bg-yellow-500';
            else if(data.status === 'sakit') badge.className += 'bg-red-500';
            else if(data.status === 'izin') badge.className += 'bg-blue-500';

            // Set Photo
            const photoEl = document.getElementById('modalPhoto');
            const noPhotoEl = document.getElementById('modalNoPhoto');
            if (data.photo_url) {
                photoEl.src = data.photo_url;
                photoEl.classList.remove('hidden');
                noPhotoEl.classList.add('hidden');
            } else {
                photoEl.classList.add('hidden');
                noPhotoEl.classList.remove('hidden');
            }

            // Show Modal
            document.getElementById('detailModal').classList.remove('hidden');

            // Handle Map
            const noLocationEl = document.getElementById('modalNoLocation');
            if (data.lat && data.lng) {
                noLocationEl.classList.add('hidden');
                
                if (!map) {
                    map = L.map('modalMapContainer').setView([data.lat, data.lng], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(map);
                    marker = L.marker([data.lat, data.lng]).addTo(map);
                } else {
                    map.setView([data.lat, data.lng], 15);
                    marker.setLatLng([data.lat, data.lng]);
                }
                marker.bindPopup("<b>" + data.name + "</b><br>Lokasi absen.").openPopup();

                setTimeout(() => { map.invalidateSize(); }, 200);
            } else {
                if (map) {
                    map.remove();
                    map = null;
                }
                noLocationEl.classList.remove('hidden');
            }
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</div>
