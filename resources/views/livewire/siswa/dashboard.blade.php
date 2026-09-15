<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col md:flex-row justify-between items-center border-l-4 border-primary-500 gap-4">
        <div class="flex items-center gap-4">
            <div class="relative group">
                @php
                    $user = auth()->user();
                    $avatarUrl = $user->profile_photo_path 
                        ? '/storage/' . $user->profile_photo_path 
                        : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF';
                @endphp
                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-primary-100">
                <label class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    <input type="file" wire:model="profilePhoto" class="hidden" accept="image/*">
                </label>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-neutral-800">Halo, {{ auth()->user()->name }} 👋</h2>
                <p class="text-neutral-500 mt-1">Jangan lupa untuk mengisi absensi hari ini!</p>
                <div wire:loading wire:target="profilePhoto" class="text-xs text-primary-500 mt-1">Mengunggah foto...</div>
                @if (session()->has('profile_success'))
                    <div class="text-xs text-green-600 mt-1">{{ session('profile_success') }}</div>
                @endif
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm font-medium text-neutral-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            <p class="text-xl font-bold text-primary-600" wire:poll.1s>{{ \Carbon\Carbon::now()->format('H:i') }}</p>
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

    @if($attendanceToday)
        <div class="bg-white rounded-xl shadow-sm p-6 text-center max-w-lg mx-auto">
            @if($attendanceToday->photo_path)
                <div class="mb-6 relative w-32 h-32 mx-auto">
                    <img src="/storage/{{ $attendanceToday->photo_path }}" class="w-full h-full object-cover rounded-full border-4 border-green-100 shadow-sm" alt="Bukti Absen">
                    <div class="absolute bottom-0 right-0 bg-green-500 text-white p-1.5 rounded-full border-2 border-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
            @else
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-500 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                @if($attendanceToday->mood)
                    <div class="mt-4 p-4 bg-neutral-50 rounded-lg border border-neutral-100">
                        <p class="font-medium text-neutral-600 text-xs uppercase tracking-wider mb-1">Refleksi / Jurnal</p>
                        <p class="text-neutral-700 italic">"{{ $attendanceToday->reflection_text }}"</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-bold text-neutral-800 mb-4 border-b pb-2">Formulir Absensi</h3>
            
            <form wire:submit="submitAttendance" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Status Kehadiran</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="status" value="hadir" class="peer sr-only">
                            <div class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-primary-50 peer-checked:border-primary-500 peer-checked:text-primary-700 hover:bg-neutral-50 transition-all">
                                <span class="block text-xl mb-1">👍</span>
                                <span class="font-medium">Hadir</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="status" value="terlambat" class="peer sr-only">
                            <div class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-yellow-50 peer-checked:border-yellow-500 peer-checked:text-yellow-700 hover:bg-neutral-50 transition-all">
                                <span class="block text-xl mb-1">⏰</span>
                                <span class="font-medium">Terlambat</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="status" value="sakit" class="peer sr-only">
                            <div class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 hover:bg-neutral-50 transition-all">
                                <span class="block text-xl mb-1">🤒</span>
                                <span class="font-medium">Sakit</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="status" value="izin" class="peer sr-only">
                            <div class="text-center p-3 rounded-lg border border-neutral-200 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 hover:bg-neutral-50 transition-all">
                                <span class="block text-xl mb-1">📝</span>
                                <span class="font-medium">Izin</span>
                            </div>
                        </label>
                    </div>
                    @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Perasaan Anda Hari Ini (Mood)</label>
                    <select wire:model="mood" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">-- Pilih Mood --</option>
                        <option value="senang">😊 Senang</option>
                        <option value="sedih">😢 Sedih</option>
                        <option value="lelah">😩 Lelah</option>
                        <option value="semangat">🔥 Semangat</option>
                        <option value="netral">😐 Biasa Saja</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Jurnal / Refleksi Harian <span class="text-red-500">*</span></label>
                    <textarea wire:model="reflection_text" rows="3" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Ceritakan singkat hari ini (Maksimal 10 kata)..."></textarea>
                    @error('reflection_text') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Camera Component -->
                <div x-data="cameraComponent()" x-init="initCamera()" class="border border-neutral-200 rounded-lg p-4 bg-neutral-50">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Foto Kehadiran (Bukti)</label>
                    
                    <div x-show="!photoCaptured" class="relative bg-black rounded-lg overflow-hidden aspect-video flex items-center justify-center">
                        <video x-ref="video" class="w-full h-full object-cover" autoplay playsinline></video>
                        <div x-show="cameraError" class="absolute inset-0 flex items-center justify-center bg-neutral-800 text-white text-center p-4">
                            <span x-text="cameraError"></span>
                        </div>
                    </div>
                    
                    <div x-show="photoCaptured" class="relative rounded-lg overflow-hidden aspect-video border border-neutral-300">
                        <img x-ref="photoPreview" class="w-full h-full object-cover">
                        <input type="hidden" wire:model="photo">
                    </div>

                    <div class="mt-4 flex justify-center gap-3">
                        <button type="button" x-show="!photoCaptured" @click="capturePhoto()" :disabled="!!cameraError" class="bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium disabled:opacity-50 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ambil Foto
                        </button>
                        <button type="button" x-show="photoCaptured" @click="retakePhoto()" class="bg-neutral-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Ulangi Foto
                        </button>
                    </div>
                    <canvas x-ref="canvas" class="hidden"></canvas>
                </div>
                
                <script>
                    function cameraComponent() {
                        return {
                            stream: null,
                            photoCaptured: false,
                            cameraError: '',
                            
                            initCamera() {
                                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                                    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
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
                                
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                                
                                const dataUrl = canvas.toDataURL('image/png');
                                this.$refs.photoPreview.src = dataUrl;
                                this.$wire.set('photo', dataUrl);
                                this.photoCaptured = true;
                            },
                            
                            retakePhoto() {
                                this.photoCaptured = false;
                                this.$wire.set('photo', null);
                            }
                        }
                    }
                </script>

                <!-- Location Component -->
                <div x-data="locationComponent()" x-init="initLocation()">
                    <input type="hidden" wire:model="latitude">
                    <input type="hidden" wire:model="longitude">
                    <div x-show="locationError" class="text-xs text-red-500 mt-1" x-text="locationError"></div>
                    <div x-show="!locationError && latitude && longitude" class="text-xs text-green-600 mt-1 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
                                            switch(error.code) {
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
                                        },
                                        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                                    );
                                } else {
                                    this.locationError = "Browser Anda tidak mendukung Geolocation.";
                                }
                            }
                        }
                    }
                </script>

                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                    Kirim Absensi
                </button>
            </form>
        </div>
    @endif
</div>
