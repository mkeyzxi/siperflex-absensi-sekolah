<div class="max-w-7xl mx-auto space-y-6 pb-10">
    <!-- Header Card -->
    <div
        class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col md:flex-row justify-between items-center gap-6">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-primary-400 opacity-20 blur-xl">
        </div>

        <div class="relative z-10 flex items-center gap-5 w-full md:w-auto">
            @php
                $avatarUrl = auth()->user()->profile_photo_path
                    ? '/storage/' . auth()->user()->profile_photo_path
                    : 'https://ui-avatars.com/api/?name=' .
                        urlencode(auth()->user()->name) .
                        '&color=7F9CF5&background=EBF4FF';
            @endphp
            <div class="relative group">
                <img src="{{ $avatarUrl }}" alt="{{ auth()->user()->name }}"
                    class="w-20 h-20 rounded-full border-4 border-white/20 shadow-xl object-cover group-hover:border-white/40 transition-colors">
                <label
                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                        </path>
                    </svg>
                    <input type="file" wire:model.live="profilePhoto" class="hidden" accept="image/*">
                </label>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Halo, {{ auth()->user()->name }} 👋
                </h2>
                <p class="text-primary-100 mt-1.5 md:text-lg">Jangan lupa untuk mengisi absensi hari ini!</p>
                <div wire:loading wire:target="profilePhoto" class="text-xs text-primary-200 mt-2">Mengunggah foto...
                </div>
                @error('profilePhoto')
                    <div
                        class="text-xs text-red-200 mt-2 font-medium bg-red-900/40 px-2 py-1 rounded-md inline-block border border-red-500/30">
                        ⚠ {{ $message }}</div>
                @enderror
                @if (session()->has('profile_success'))
                    <div class="text-xs text-green-300 mt-2 font-medium">{{ session('profile_success') }}</div>
                @endif
            </div>
        </div>
        <div
            class="text-left md:text-right w-full md:w-auto mt-4 md:mt-0 p-4 md:p-0 bg-white/10 md:bg-transparent rounded-xl md:rounded-none backdrop-blur-sm md:backdrop-blur-none border border-white/10 md:border-none">
            <p class="text-sm font-medium text-primary-100 uppercase tracking-wider">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            <p class="text-3xl md:text-4xl font-extrabold text-white mt-1 drop-shadow-md" wire:poll.1s>
                {{ \Carbon\Carbon::now()->format('H:i') }}</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Attendance Form/Status -->
        <div class="lg:col-span-1 space-y-6">
            @if ($attendanceToday)
                <div class="md:bg-white md:rounded-xl md:shadow-sm md:border md:border-neutral-100 md:p-6 text-center">
                    @if ($attendanceToday->photo_path)
                        <div class="mb-6 relative w-32 h-32 mx-auto">
                            <img src="/storage/{{ $attendanceToday->photo_path }}"
                                class="w-full h-full object-cover rounded-full border-4 border-green-100 shadow-sm"
                                alt="Bukti Absen">
                            <div
                                class="absolute bottom-0 right-0 bg-green-500 text-white p-1.5 rounded-full border-2 border-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                    @else
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    @endif

                    <h3 class="text-xl font-bold text-neutral-800">Anda sudah absen hari ini</h3>
                    <div class="mt-4 space-y-2 text-sm">
                        <p class="text-neutral-600 flex justify-center gap-2">
                            <span class="font-medium">Status:</span>
                            <span class="font-bold text-primary-600 uppercase">{{ $attendanceToday->status }}</span>
                        </p>
                        <p class="text-neutral-600 flex justify-center gap-2">
                            <span class="font-medium">Waktu:</span>
                            <span>{{ \Carbon\Carbon::parse($attendanceToday->time)->format('H:i') }} WIB</span>
                        </p>
                        @if ($attendanceToday->mood)
                            <div class="mt-4 p-4 bg-neutral-50 rounded-lg border border-neutral-100">
                                <p class="font-medium text-neutral-600 text-xs uppercase tracking-wider mb-1">Refleksi /
                                    Jurnal</p>
                                <p class="text-neutral-700 italic">"{{ $attendanceToday->reflection_text }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="md:bg-white md:rounded-xl md:shadow-sm md:border md:border-neutral-100 md:p-6">
                    <h3 class="text-xl font-bold text-neutral-800 mb-4 md:border-b md:pb-2">Formulir Absensi</h3>

                    <form wire:submit="submitAttendance" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Status Kehadiran</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="status" value="hadir" class="peer sr-only">
                                    <div
                                        class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-primary-50 peer-checked:border-primary-500 peer-checked:text-primary-700 bg-white hover:bg-neutral-50 transition-all shadow-sm">
                                        <span class="block text-xl mb-1">👍</span>
                                        <span class="font-medium text-sm">Hadir</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="status" value="terlambat" class="peer sr-only">
                                    <div
                                        class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-yellow-50 peer-checked:border-yellow-500 peer-checked:text-yellow-700 bg-white hover:bg-neutral-50 transition-all shadow-sm">
                                        <span class="block text-xl mb-1">⏰</span>
                                        <span class="font-medium text-sm">Terlambat</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="status" value="sakit" class="peer sr-only">
                                    <div
                                        class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 bg-white hover:bg-neutral-50 transition-all shadow-sm">
                                        <span class="block text-xl mb-1">🤒</span>
                                        <span class="font-medium text-sm">Sakit</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="status" value="izin" class="peer sr-only">
                                    <div
                                        class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 bg-white hover:bg-neutral-50 transition-all shadow-sm">
                                        <span class="block text-xl mb-1">📝</span>
                                        <span class="font-medium text-sm">Izin</span>
                                    </div>
                                </label>
                            </div>
                            @error('status')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Perasaan Anda Hari Ini
                                (Mood)</label>
                            <select wire:model="mood"
                                class="w-full rounded-md border border-neutral-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 shadow-sm">
                                <option value="">-- Pilih Mood --</option>
                                <option value="senang">😊 Senang</option>
                                <option value="sedih">😢 Sedih</option>
                                <option value="lelah">😩 Lelah</option>
                                <option value="semangat">🔥 Semangat</option>
                                <option value="netral">😐 Biasa Saja</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Jurnal / Refleksi Harian
                                <span class="text-red-500">*</span></label>
                            <textarea wire:model="reflection_text" rows="3"
                                class="w-full rounded-md border border-neutral-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 shadow-sm"
                                placeholder="Ceritakan singkat hari ini (Maksimal 10 kata)..."></textarea>
                            @error('reflection_text')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Camera Component -->
                        <div x-data="cameraComponent()" x-init="initCamera()"
                            class="border border-neutral-200 rounded-lg p-4 bg-white md:bg-neutral-50 shadow-sm">
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Foto Kehadiran
                                (Bukti) <span class="text-red-500">*</span></label>

                            <div x-show="!photoCaptured"
                                class="relative bg-black rounded-lg overflow-hidden aspect-video flex items-center justify-center">
                                <video x-ref="video" class="w-full h-full object-cover" autoplay playsinline></video>
                                <div x-show="cameraError"
                                    class="absolute inset-0 flex items-center justify-center bg-neutral-800 text-white text-center p-4">
                                    <span x-text="cameraError"></span>
                                </div>
                            </div>

                            <div x-show="photoCaptured"
                                class="relative rounded-lg overflow-hidden aspect-video border border-neutral-300">
                                <img :src="photoData" class="w-full h-full object-cover">
                                <input type="hidden" wire:model="photo" required>
                            </div>

                            <div class="mt-4 flex justify-center gap-3">
                                <button type="button" x-show="!photoCaptured" @click="capturePhoto()"
                                    :disabled="!!cameraError"
                                    class="bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium disabled:opacity-50 flex items-center gap-2 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Ambil Foto
                                </button>
                                <button type="button" x-show="photoCaptured" @click="retakePhoto()"
                                    class="bg-neutral-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Ulangi Foto
                                </button>
                            </div>
                            @error('photo')
                                <span class="text-red-500 text-xs mt-2 block text-center font-medium">{{ $message }}</span>
                            @enderror
                            <canvas x-ref="canvas" class="hidden"></canvas>
                        </div>

                        <script>
                            function cameraComponent() {
                                return {
                                    status: @entangle('status'),
                                    stream: null,
                                    photoCaptured: false,
                                    cameraError: '',
                                    photoData: '',

                                    initCamera() {
                                        this.startCamera();

                                        this.$watch('status', () => {
                                            if (!this.photoCaptured) {
                                                this.startCamera();
                                            }
                                        });
                                    },

                                    startCamera() {
                                        if (this.stream) {
                                            this.stream.getTracks().forEach(track => track.stop());
                                        }

                                        let mode = (this.status === 'izin' || this.status === 'sakit') ? 'environment' : 'user';

                                        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                                            navigator.mediaDevices.getUserMedia({
                                                    video: {
                                                        facingMode: mode
                                                    }
                                                })
                                                .then(stream => {
                                                    this.stream = stream;
                                                    this.$refs.video.srcObject = stream;
                                                    this.cameraError = '';
                                                })
                                                .catch(err => {
                                                    this.cameraError = 'Kamera tidak dapat diakses: ' + err.message;
                                                    console.error("Camera error:", err);
                                                });
                                        } else {
                                            this.cameraError = 'Browser Anda tidak mendukung akses kamera.';
                                        }
                                    },

                                    capturePhoto() {
                                        const video = this.$refs.video;
                                        const canvas = this.$refs.canvas;
                                        const context = canvas.getContext('2d');

                                        // Resize image to prevent Payload Too Large error
                                        const MAX_WIDTH = 800;
                                        const MAX_HEIGHT = 800;
                                        let width = video.videoWidth;
                                        let height = video.videoHeight;

                                        if (width > height) {
                                            if (width > MAX_WIDTH) {
                                                height *= MAX_WIDTH / width;
                                                width = MAX_WIDTH;
                                            }
                                        } else {
                                            if (height > MAX_HEIGHT) {
                                                width *= MAX_HEIGHT / height;
                                                height = MAX_HEIGHT;
                                            }
                                        }

                                        canvas.width = width;
                                        canvas.height = height;
                                        context.drawImage(video, 0, 0, width, height);

                                        // Convert to JPEG with 70% quality for smaller size
                                        const dataUrl = canvas.toDataURL('image/jpeg', 0.7);

                                        this.photoData = dataUrl;
                                        this.$wire.set('photo', dataUrl);
                                        this.photoCaptured = true;
                                    },

                                    retakePhoto() {
                                        this.photoCaptured = false;
                                        this.photoData = '';
                                        this.$wire.set('photo', null);
                                        this.startCamera();
                                    }
                                }
                            }
                        </script>

                        <!-- Location Component -->
                        <div x-data="locationComponent()" x-init="initLocation()">
                            <input type="hidden" wire:model="latitude">
                            <input type="hidden" wire:model="longitude">
                            <div x-show="locationError" class="text-xs text-red-500 mt-1" x-text="locationError">
                            </div>
                            <div x-show="!locationError && latitude && longitude"
                                class="text-xs text-green-600 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Lokasi terdeteksi
                            </div>
                        </div>

                        <script>
                            function locationComponent() {
                                return {
                                    latitude: null,
                                    longitude: null,
                                    locationError: 'Mencari lokasi...',

                                    initLocation() {
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(
                                                (position) => {
                                                    this.latitude = position.coords.latitude;
                                                    this.longitude = position.coords.longitude;
                                                    this.$wire.set('latitude', this.latitude);
                                                    this.$wire.set('longitude', this.longitude);
                                                    this.locationError = '';
                                                },
                                                (error) => {
                                                    console.error("Error getting location:", error);
                                                    switch (error.code) {
                                                        case error.PERMISSION_DENIED:
                                                            this.locationError = "Izin akses lokasi ditolak.";
                                                            break;
                                                        case error.POSITION_UNAVAILABLE:
                                                            this.locationError = "Informasi lokasi tidak tersedia.";
                                                            break;
                                                        case error.TIMEOUT:
                                                            this.locationError = "Waktu permintaan lokasi habis.";
                                                            break;
                                                        default:
                                                            this.locationError = "Terjadi kesalahan saat mengambil lokasi.";
                                                    }
                                                }, {
                                                    enableHighAccuracy: true,
                                                    timeout: 10000,
                                                    maximumAge: 0
                                                }
                                            );
                                        } else {
                                            this.locationError = "Browser Anda tidak mendukung Geolocation.";
                                        }
                                    }
                                }
                            }
                        </script>

                        <button type="submit"
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-lg transition-colors shadow-md">
                            Kirim Absensi
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Right Column: Attendance History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-100 overflow-hidden">
                <div class="p-4 md:p-6 border-b border-neutral-100 flex items-center justify-between bg-neutral-50/50">
                    <h3 class="text-lg font-bold text-neutral-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Absensi Anda
                    </h3>
                </div>

                <div class="p-0">
                    @if (count($attendanceHistory) > 0)
                        <!-- Mobile History View (Cards) -->
                        <div class="block md:hidden divide-y divide-neutral-100">
                            @foreach ($attendanceHistory as $history)
                                <div class="p-4 hover:bg-neutral-50 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-bold text-neutral-800 text-sm">
                                                {{ \Carbon\Carbon::parse($history->date)->translatedFormat('l, d F Y') }}
                                            </p>
                                            <p class="text-xs text-neutral-500 flex items-center gap-1 mt-0.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($history->time)->format('H:i') }} WIB
                                            </p>
                                        </div>
                                        <div>
                                            @switch($history->status)
                                                @case('hadir')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800 border border-green-200">HADIR</span>
                                                @break

                                                @case('terlambat')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">TERLAMBAT</span>
                                                @break

                                                @case('sakit')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">SAKIT</span>
                                                @break

                                                @case('izin')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">IZIN</span>
                                                @break
                                            @endswitch
                                        </div>
                                    </div>
                                    @if ($history->reflection_text)
                                        <div class="bg-white border border-neutral-100 rounded p-2.5 mt-2">
                                            <div class="flex items-start gap-2 text-sm">
                                                @if ($history->mood)
                                                    <span title="{{ ucfirst($history->mood) }}">
                                                        @switch($history->mood)
                                                            @case('senang')
                                                                😊
                                                            @break

                                                            @case('sedih')
                                                                😢
                                                            @break

                                                            @case('lelah')
                                                                😩
                                                            @break

                                                            @case('semangat')
                                                                🔥
                                                            @break

                                                            @case('netral')
                                                                😐
                                                            @break
                                                        @endswitch
                                                    </span>
                                                @endif
                                                <p class="text-neutral-600 italic leading-tight">
                                                    "{{ $history->reflection_text }}"</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop History View (Table) -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="bg-neutral-50/50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-100">
                                        <th class="px-6 py-4 font-bold">Tanggal</th>
                                        <th class="px-6 py-4 font-bold text-center">Status</th>
                                        <th class="px-6 py-4 font-bold text-center">Waktu</th>
                                        <th class="px-6 py-4 font-bold w-1/2">Refleksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-100">
                                    @foreach ($attendanceHistory as $history)
                                        <tr class="hover:bg-primary-50/30 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-neutral-800 text-sm">
                                                    {{ \Carbon\Carbon::parse($history->date)->translatedFormat('d M Y') }}
                                                </div>
                                                <div class="text-xs text-neutral-500">
                                                    {{ \Carbon\Carbon::parse($history->date)->translatedFormat('l') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @switch($history->status)
                                                    @case('hadir')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm">HADIR</span>
                                                    @break

                                                    @case('terlambat')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 shadow-sm">TERLAMBAT</span>
                                                    @break

                                                    @case('sakit')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200 shadow-sm">SAKIT</span>
                                                    @break

                                                    @case('izin')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">IZIN</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div
                                                    class="text-sm font-bold text-neutral-800 flex items-center justify-center gap-1">
                                                    <svg class="w-4 h-4 text-neutral-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($history->time)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($history->reflection_text)
                                                    <div class="flex items-start gap-2">
                                                        @if ($history->mood)
                                                            <span title="{{ ucfirst($history->mood) }}"
                                                                class="text-lg leading-none mt-0.5">
                                                                @switch($history->mood)
                                                                    @case('senang')
                                                                        😊
                                                                    @break

                                                                    @case('sedih')
                                                                        😢
                                                                    @break

                                                                    @case('lelah')
                                                                        😩
                                                                    @break

                                                                    @case('semangat')
                                                                        🔥
                                                                    @break

                                                                    @case('netral')
                                                                        😐
                                                                    @break
                                                                @endswitch
                                                            </span>
                                                        @endif
                                                        <p
                                                            class="text-sm text-neutral-700 italic font-medium leading-tight">
                                                            "{{ $history->reflection_text }}"</p>
                                                    </div>
                                                @else
                                                    <span class="text-neutral-400 text-sm font-medium">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center p-8">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-100 text-neutral-400 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-neutral-700 font-bold mb-1">Belum ada riwayat absensi</h4>
                            <p class="text-sm text-neutral-500">Data absensi hari sebelumnya akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
