<div class="space-y-6">
    <div class="flex items-center space-x-3 mb-2">
        <a href="{{ route('admin.kelas.index') }}" class="text-neutral-500 hover:text-primary-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-bold text-neutral-800">Detail Kelas: {{ $classRoom->class_name }}</h2>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-primary-500 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h3 class="text-lg font-bold text-neutral-800">{{ $classRoom->class_name }}</h3>
            <p class="text-sm text-neutral-500 mt-1">
                Tingkat: {{ $classRoom->grade_level }} 
                @if($classRoom->major) | Jurusan: {{ $classRoom->major }} @endif
            </p>
            <p class="text-sm text-neutral-500">Tahun Ajaran: {{ $classRoom->academicYear->name ?? '-' }}</p>
        </div>
        <div class="mt-4 md:mt-0 text-left md:text-right">
            <p class="text-sm text-neutral-500">Wali Kelas</p>
            <p class="font-bold text-primary-700">{{ $classRoom->homeroomTeacher->name ?? 'Belum ditentukan' }}</p>
            @if($classRoom->homeroomTeacher)
                <p class="text-xs text-neutral-500">NIP: {{ $classRoom->homeroomTeacher->nip ?? '-' }}</p>
            @endif
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="flex border-b border-neutral-200 bg-neutral-50">
            <button wire:click="setTab('siswa')" class="px-6 py-3 text-sm font-bold border-b-2 transition-colors {{ $activeTab === 'siswa' ? 'border-primary-600 text-primary-600 bg-white' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100' }}">
                Daftar Siswa ({{ $classRoom->students->count() }})
            </button>
            <button wire:click="setTab('guru')" class="px-6 py-3 text-sm font-bold border-b-2 transition-colors {{ $activeTab === 'guru' ? 'border-primary-600 text-primary-600 bg-white' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100' }}">
                Guru Pengajar ({{ $classRoom->teachers->count() }})
            </button>
        </div>

        <div class="p-6">
            @if($activeTab === 'siswa')
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-lg font-semibold text-neutral-800">Siswa di Kelas Ini</h4>
                    <button wire:click="openAddStudentModal" class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Siswa
                    </button>
                </div>
                
                <div class="overflow-x-auto rounded-lg border border-neutral-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 text-neutral-600 text-xs uppercase tracking-wider border-b border-neutral-200">
                                <th class="p-3 font-semibold">Nama Siswa</th>
                                <th class="p-3 font-semibold">NIS</th>
                                <th class="p-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @forelse($classRoom->students as $student)
                                <tr class="hover:bg-neutral-50">
                                    <td class="p-3 font-medium text-neutral-800">{{ $student->name }}</td>
                                    <td class="p-3 text-neutral-600">{{ $student->nis ?? '-' }}</td>
                                    <td class="p-3 text-right">
                                        <button wire:click="removeStudent({{ $student->id }})" onclick="confirm('Keluarkan siswa ini dari kelas?') || event.stopImmediatePropagation()" class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors">Keluarkan</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-6 text-center text-neutral-500 italic">Belum ada siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            @if($activeTab === 'guru')
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-lg font-semibold text-neutral-800">Guru Pengajar di Kelas Ini</h4>
                    <button wire:click="openAddTeacherModal" class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Guru
                    </button>
                </div>
                
                <div class="overflow-x-auto rounded-lg border border-neutral-200">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 text-neutral-600 text-xs uppercase tracking-wider border-b border-neutral-200">
                                <th class="p-3 font-semibold">Nama Guru</th>
                                <th class="p-3 font-semibold">NIP</th>
                                <th class="p-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @forelse($classRoom->teachers as $teacher)
                                <tr class="hover:bg-neutral-50">
                                    <td class="p-3 font-medium text-neutral-800">{{ $teacher->name }}</td>
                                    <td class="p-3 text-neutral-600">{{ $teacher->nip ?? '-' }}</td>
                                    <td class="p-3 text-right">
                                        <button wire:click="removeTeacher({{ $teacher->id }})" onclick="confirm('Hapus penugasan guru ini dari kelas?') || event.stopImmediatePropagation()" class="text-red-500 hover:text-red-700 text-sm font-medium transition-colors">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-6 text-center text-neutral-500 italic">Belum ada guru yang ditugaskan ke kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL ADD STUDENT -->
    @if($showAddStudentModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="backdrop-filter: blur(2px);">
        <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-1/2 max-w-2xl overflow-hidden flex flex-col max-h-[85vh]">
            <div class="flex justify-between items-center p-4 border-b bg-neutral-50">
                <h3 class="text-lg font-bold text-neutral-800">Tambah Siswa ke Kelas</h3>
                <button wire:click="closeAddStudentModal" class="text-neutral-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-4 border-b">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="searchStudent" class="w-full rounded-md border border-neutral-300 pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Cari nama atau NIS siswa...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                @if(count($availableStudents) > 0)
                    <div class="space-y-2">
                        @foreach($availableStudents as $student)
                        <label class="flex items-center p-3 border border-neutral-200 rounded-lg cursor-pointer hover:bg-neutral-50 transition-colors">
                            <input type="checkbox" wire:model="selectedStudents" value="{{ $student->id }}" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500 w-5 h-5 mr-3">
                            <div>
                                <p class="font-medium text-neutral-800">{{ $student->name }}</p>
                                <p class="text-xs text-neutral-500">NIS: {{ $student->nis ?? '-' }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-neutral-500">
                        <p>Tidak ada siswa yang tersedia atau cocok dengan pencarian.</p>
                        <p class="text-sm mt-1">Pastikan siswa sudah didaftarkan dan belum bergabung di kelas ini.</p>
                    </div>
                @endif
            </div>
            <div class="p-4 border-t bg-neutral-50 flex justify-between items-center">
                <span class="text-sm font-medium text-neutral-600">{{ count($selectedStudents) }} Siswa dipilih</span>
                <div class="space-x-2">
                    <button wire:click="closeAddStudentModal" class="px-4 py-2 bg-neutral-200 text-neutral-800 font-medium rounded-lg hover:bg-neutral-300 transition-colors">Batal</button>
                    <button wire:click="addSelectedStudents" class="px-4 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors disabled:opacity-50" @if(empty($selectedStudents)) disabled @endif>Tambahkan</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL ADD TEACHER -->
    @if($showAddTeacherModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="backdrop-filter: blur(2px);">
        <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-1/2 max-w-2xl overflow-hidden flex flex-col max-h-[85vh]">
            <div class="flex justify-between items-center p-4 border-b bg-neutral-50">
                <h3 class="text-lg font-bold text-neutral-800">Tambah Guru Pengajar</h3>
                <button wire:click="closeAddTeacherModal" class="text-neutral-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-4 border-b">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="searchTeacher" class="w-full rounded-md border border-neutral-300 pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Cari nama atau NIP guru...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                @if(count($availableTeachers) > 0)
                    <div class="space-y-2">
                        @foreach($availableTeachers as $teacher)
                        <label class="flex items-center p-3 border border-neutral-200 rounded-lg cursor-pointer hover:bg-neutral-50 transition-colors">
                            <input type="checkbox" wire:model="selectedTeachers" value="{{ $teacher->id }}" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500 w-5 h-5 mr-3">
                            <div>
                                <p class="font-medium text-neutral-800">{{ $teacher->name }}</p>
                                <p class="text-xs text-neutral-500">NIP: {{ $teacher->nip ?? '-' }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-neutral-500">
                        <p>Tidak ada guru yang tersedia atau cocok dengan pencarian.</p>
                        <p class="text-sm mt-1">Pastikan guru sudah didaftarkan dan belum ditugaskan di kelas ini.</p>
                    </div>
                @endif
            </div>
            <div class="p-4 border-t bg-neutral-50 flex justify-between items-center">
                <span class="text-sm font-medium text-neutral-600">{{ count($selectedTeachers) }} Guru dipilih</span>
                <div class="space-x-2">
                    <button wire:click="closeAddTeacherModal" class="px-4 py-2 bg-neutral-200 text-neutral-800 font-medium rounded-lg hover:bg-neutral-300 transition-colors">Batal</button>
                    <button wire:click="addSelectedTeachers" class="px-4 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors disabled:opacity-50" @if(empty($selectedTeachers)) disabled @endif>Tambahkan</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
