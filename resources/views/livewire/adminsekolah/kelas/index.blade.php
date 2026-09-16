<div class="space-y-6">
    <!-- Modern Header Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-primary-400 opacity-20 blur-xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Manajemen Kelas</h2>
            <p class="text-primary-100 font-medium mt-1">Kelola data kelas dan rombongan belajar</p>
        </div>
        
        <div class="relative z-10 w-full sm:w-auto mt-4 sm:mt-0 text-left sm:text-right">
            <button wire:click="openForm" class="bg-white text-primary-700 hover:bg-primary-50 px-5 py-2.5 rounded-xl font-bold shadow-lg transition-colors flex items-center gap-2 w-full sm:w-auto justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kelas
            </button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
            <span class="block sm:inline font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white p-4 rounded-2xl shadow-sm border border-neutral-100 mb-6">
        <div class="relative w-full md:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama kelas, tingkat..." class="w-full pl-10 pr-3 py-2.5 bg-neutral-50 border border-neutral-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
        </div>
        
        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <div class="flex items-center space-x-2 bg-neutral-50 px-3 py-2 rounded-xl border border-neutral-200 flex-1 md:flex-none justify-center">
                <input type="file" wire:model="importFile" class="w-24 text-sm text-neutral-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" accept=".csv">
                <button wire:click="importCsv" wire:loading.attr="disabled" class="text-sm font-medium text-primary-600 hover:text-primary-800" @if(!$importFile) disabled style="opacity:0.5" @endif>
                    <span wire:loading.remove wire:target="importCsv">Import CSV</span>
                    <span wire:loading wire:target="importCsv">Loading...</span>
                </button>
            </div>
            
            <button wire:click="exportCsv" class="bg-neutral-100 hover:bg-neutral-200 text-neutral-700 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors flex items-center justify-center gap-2 border border-neutral-200 flex-1 md:flex-none">
                <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export CSV
            </button>
        </div>
    </div>

    @if($isFormOpen)
        <div class="bg-white rounded-2xl shadow-md border border-neutral-100 p-6 md:p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-500 to-primary-300"></div>
            <h3 class="text-xl font-bold text-neutral-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                {{ $isEditing ? 'Edit Data Kelas' : 'Tambah Kelas Baru' }}
            </h3>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Tingkat / Grade <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="grade_level" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required placeholder="Contoh: 10, 11, 12">
                            @error('grade_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Jurusan / Peminatan</label>
                            <input type="text" wire:model="major" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Contoh: MIPA, IPS (Opsional)">
                            @error('major') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Nama Kelas Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="class_name" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required placeholder="Contoh: X MIPA 1">
                            @error('class_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="lg:col-span-3">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Wali Kelas</label>
                            <select wire:model="homeroom_teacher_id" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <option value="">-- Pilih Wali Kelas --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }} (NIP: {{ $teacher->nip ?? '-' }})</option>
                                @endforeach
                            </select>
                            @error('homeroom_teacher_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="lg:col-span-1 flex items-center">
                            <label class="flex items-center space-x-2 mt-4 cursor-pointer">
                                <input type="checkbox" wire:model="is_active" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500 w-5 h-5">
                                <span class="text-sm font-medium text-neutral-700">Kelas Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" wire:click="closeForm" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 text-sm hover:bg-neutral-100 transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Mobile View (Cards) -->
        <div class="block md:hidden space-y-4">
            @forelse($classes as $class)
                    <div class="bg-white rounded-2xl border border-neutral-100 p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <!-- Removed left border indicator, relying on modern styling and badges -->
                        
                        <div class="flex justify-between items-start mb-4 border-b border-neutral-50 pb-4">
                            <div>
                                <h4 class="font-bold text-neutral-800 text-lg flex items-center gap-2">
                                    {{ $class->class_name }}
                                </h4>
                                <div class="text-xs text-neutral-500 mt-1">Tingkat: <span class="font-semibold text-neutral-700">{{ $class->grade_level }}</span> {{ $class->major ? ' | ' . $class->major : '' }}</div>
                            </div>
                            <div class="text-right">
                                @if(!$class->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 border border-red-200 text-red-700 text-xs rounded-md font-bold shadow-sm">Nonaktif</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-50 border border-green-200 text-green-700 text-xs rounded-md font-bold shadow-sm">Aktif</span>
                                @endif
                            </div>
                        </div>
                    
                    <div class="bg-neutral-50 rounded-lg p-3 space-y-2 mb-4 border border-neutral-100">
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-xs text-neutral-500">Jumlah Siswa:</span>
                            <span class="inline-block bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-md border border-blue-200">
                                {{ $class->students_count }} Siswa
                            </span>
                        </div>
                    </div>
                    
                    <div class="bg-neutral-50 rounded-lg p-3 space-y-2 mb-4 border border-neutral-100">
                        <div class="flex items-start text-sm">
                            <svg class="w-4 h-4 mr-2 text-neutral-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <div>
                                <span class="text-xs text-neutral-500 block">Wali Kelas:</span>
                                @if($class->homeroomTeacher)
                                    <span class="font-medium text-neutral-800">{{ $class->homeroomTeacher->name }}</span>
                                @else
                                    <span class="text-neutral-400 italic">Belum ditentukan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.kelas.show', $class->id) }}" class="col-span-2 flex justify-center items-center gap-1.5 bg-primary-50 text-primary-700 hover:bg-primary-100 py-2.5 rounded-lg text-sm font-semibold transition-colors border border-primary-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Kelola Anggota
                        </a>
                        <button wire:click="openForm({{ $class->id }})" class="flex justify-center items-center gap-1.5 bg-white text-neutral-700 hover:bg-neutral-50 py-2 rounded-lg text-sm font-semibold transition-colors border border-neutral-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit
                        </button>
                        <button wire:click="delete({{ $class->id }})" onclick="confirm('Yakin ingin menghapus kelas ini? Data yang terkait mungkin akan hilang.') || event.stopImmediatePropagation()" class="flex justify-center items-center gap-1.5 bg-white text-red-700 hover:bg-red-50 py-2 rounded-lg text-sm font-semibold transition-colors border border-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 px-4 bg-neutral-50 rounded-xl border border-neutral-200">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <p class="text-neutral-500 font-medium">Belum ada data kelas.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                        <th class="p-5 font-bold">Nama Kelas</th>
                        <th class="p-5 font-bold">Tingkat / Jurusan</th>
                        <th class="p-5 font-bold">Wali Kelas</th>
                        <th class="p-5 font-bold text-center">Jumlah Siswa</th>
                        <th class="p-5 font-bold text-center">Status</th>
                        <th class="p-5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($classes as $class)
                        <tr class="hover:bg-primary-50/50 transition-colors group">
                            <td class="p-5">
                                <div class="font-bold text-neutral-800 text-base group-hover:text-primary-700 transition-colors">{{ $class->class_name }}</div>
                                <div class="text-xs text-neutral-500 mt-0.5">Thn Ajaran: <span class="font-medium text-neutral-600">{{ $class->academicYear->name ?? '-' }}</span></div>
                            </td>
                            <td class="p-5">
                                <div class="text-sm text-neutral-700">
                                    Tingkat: <span class="font-bold text-neutral-800">{{ $class->grade_level }}</span>
                                </div>
                                @if($class->major)
                                    <div class="text-xs text-neutral-500 mt-0.5">Jurusan: <span class="font-medium text-neutral-600">{{ $class->major }}</span></div>
                                @endif
                            </td>
                            <td class="p-5">
                                @if($class->homeroomTeacher)
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-neutral-200 text-neutral-600 flex items-center justify-center text-xs font-bold">
                                            {{ substr($class->homeroomTeacher->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-neutral-800 text-sm">{{ $class->homeroomTeacher->name }}</div>
                                            <div class="text-xs text-neutral-500">NIP: {{ $class->homeroomTeacher->nip ?? '-' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-orange-50 text-orange-700 border border-orange-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Belum ditentukan
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 text-center">
                                <span class="inline-flex items-center justify-center bg-blue-50 text-blue-700 text-sm font-bold px-3 py-1 rounded-lg border border-blue-200 shadow-sm min-w-[80px]">
                                    {{ $class->students_count }} Siswa
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                @if($class->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200 shadow-sm">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-5 text-right space-x-2">
                                <a href="{{ route('admin.kelas.show', $class->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-primary-700 hover:border-primary-300 hover:bg-primary-50 rounded-lg text-sm font-semibold transition-all shadow-sm" title="Kelola Anggota Kelas (Siswa & Guru)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Kelola Anggota
                                </a>
                                <button wire:click="openForm({{ $class->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-primary-700 hover:border-primary-300 hover:bg-primary-50 rounded-lg text-sm font-semibold transition-all shadow-sm" title="Edit Kelas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </button>
                                <button wire:click="delete({{ $class->id }})" onclick="confirm('Yakin ingin menghapus kelas ini? Data yang terkait mungkin akan hilang.') || event.stopImmediatePropagation()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-red-700 hover:border-red-300 hover:bg-red-50 rounded-lg text-sm font-semibold transition-all shadow-sm" title="Hapus Kelas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-neutral-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <p class="font-bold text-lg text-neutral-700">Belum ada data kelas</p>
                                    <p class="text-sm mt-1 text-neutral-500">Mulai buat kelas baru untuk mengelola siswa dan wali kelas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $classes->links() }}
        </div>
    </div>
</div>
