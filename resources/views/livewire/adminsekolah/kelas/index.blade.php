<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h2 class="text-2xl font-bold text-neutral-800">Manajemen Kelas</h2>
        <div class="flex flex-wrap items-center gap-2">
            <div class="flex items-center space-x-2 bg-white px-3 py-2 rounded-lg shadow-sm border border-neutral-200">
                <input type="file" wire:model="importFile" class="text-sm text-neutral-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" accept=".csv">
                <button wire:click="importCsv" wire:loading.attr="disabled" class="text-sm font-medium text-primary-600 hover:text-primary-800" @if(!$importFile) disabled style="opacity:0.5" @endif>
                    <span wire:loading.remove wire:target="importCsv">Import CSV</span>
                    <span wire:loading wire:target="importCsv">Loading...</span>
                </button>
            </div>
            
            <button wire:click="exportCsv" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export CSV
            </button>

            <button wire:click="openForm" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Kelas
            </button>
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

    <div class="bg-white rounded-xl shadow-sm p-6">
        @if($isFormOpen)
            <div class="mb-6 p-5 border border-neutral-200 rounded-lg bg-neutral-50">
                <h4 class="font-bold text-neutral-800 mb-4">{{ $isEditing ? 'Edit Data Kelas' : 'Tambah Kelas Baru' }}</h4>
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

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-600 text-sm uppercase tracking-wider border-b border-neutral-200">
                        <th class="p-3 font-semibold">Nama Kelas</th>
                        <th class="p-3 font-semibold">Tingkat / Jurusan</th>
                        <th class="p-3 font-semibold">Wali Kelas</th>
                        <th class="p-3 font-semibold text-center">Jumlah Siswa</th>
                        <th class="p-3 font-semibold text-center">Status</th>
                        <th class="p-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse($classes as $class)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="p-3">
                                <div class="font-bold text-neutral-800">{{ $class->class_name }}</div>
                                <div class="text-xs text-neutral-500">Thn Ajaran: {{ $class->academicYear->name ?? '-' }}</div>
                            </td>
                            <td class="p-3 text-sm text-neutral-700">
                                Tingkat: <span class="font-medium">{{ $class->grade_level }}</span>
                                @if($class->major)
                                    <br><span class="text-xs text-neutral-500">{{ $class->major }}</span>
                                @endif
                            </td>
                            <td class="p-3 text-sm text-neutral-600">
                                @if($class->homeroomTeacher)
                                    <div class="font-medium text-neutral-800">{{ $class->homeroomTeacher->name }}</div>
                                    <div class="text-xs text-neutral-500">{{ $class->homeroomTeacher->nip ?? '-' }}</div>
                                @else
                                    <span class="text-neutral-400 italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                <span class="inline-block bg-blue-50 text-blue-700 text-xs font-bold px-2 py-1 rounded-full border border-blue-200">
                                    {{ $class->students_count }} Siswa
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                @if($class->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('admin.kelas.show', $class->id) }}" class="inline-block px-3 py-1 bg-primary-50 text-primary-600 border border-primary-200 hover:bg-primary-100 text-sm font-medium rounded transition-colors" title="Kelola Anggota Kelas (Siswa & Guru)">
                                    Kelola Anggota
                                </a>
                                <button wire:click="openForm({{ $class->id }})" class="text-neutral-600 hover:text-primary-600 text-sm font-medium transition-colors p-1" title="Edit Kelas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button wire:click="delete({{ $class->id }})" onclick="confirm('Yakin ingin menghapus kelas ini? Data yang terkait mungkin akan hilang.') || event.stopImmediatePropagation()" class="text-neutral-600 hover:text-red-600 text-sm font-medium transition-colors p-1" title="Hapus Kelas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-neutral-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <p class="font-medium text-lg text-neutral-600">Belum ada data kelas</p>
                                    <p class="text-sm mt-1">Mulai buat kelas baru untuk mengelola siswa dan wali kelas.</p>
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
