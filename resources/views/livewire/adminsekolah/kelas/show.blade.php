<div class="space-y-6">
    <div class="flex items-center space-x-3 mb-2">
        <a href="{{ route('admin.kelas.index') }}" class="text-neutral-500 hover:text-primary-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-bold text-neutral-800">Detail Kelas: {{ $classRoom->class_name }}</h2>
    </div>

    <!-- Modern Header Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-primary-400 opacity-20 blur-xl"></div>
        
        <div class="relative z-10">
            <h3 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">{{ $classRoom->class_name }}</h3>
            <div class="flex flex-wrap items-center gap-2 mt-2 text-sm text-primary-50 font-medium">
                <span class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-md px-2.5 py-1 rounded-md border border-white/10">
                    Tingkat: {{ $classRoom->grade_level }}
                </span>
                @if($classRoom->major)
                    <span class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-md px-2.5 py-1 rounded-md border border-white/10">
                        Jurusan: {{ $classRoom->major }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-md px-2.5 py-1 rounded-md border border-white/10">
                    Tahun Ajaran: {{ $classRoom->academicYear->name ?? '-' }}
                </span>
            </div>
        </div>
        
        <div class="relative z-10 mt-4 md:mt-0 text-left md:text-right bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-4 shadow-inner">
            <p class="text-xs text-primary-200 uppercase tracking-wider font-semibold mb-1">Wali Kelas</p>
            <p class="font-bold text-lg text-white">{{ $classRoom->homeroomTeacher->name ?? 'Belum ditentukan' }}</p>
            @if($classRoom->homeroomTeacher)
                <p class="text-xs text-primary-100 font-medium mt-0.5">NIP: {{ $classRoom->homeroomTeacher->nip ?? '-' }}</p>
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
                
                <!-- Mobile View (Cards) -->
                <div class="block md:hidden p-2 space-y-3 mt-4">
                    @forelse($classRoom->students as $student)
                        <div class="bg-white rounded-xl border border-neutral-200 p-4 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base flex-shrink-0">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-neutral-800 text-sm">{{ $student->name }}</h4>
                                    <div class="text-xs text-neutral-500 mt-0.5">NIS: <span class="font-medium text-neutral-600">{{ $student->nis ?? '-' }}</span></div>
                                </div>
                            </div>
                            <button wire:click="removeStudent({{ $student->id }})" onclick="confirm('Keluarkan siswa ini dari kelas?') || event.stopImmediatePropagation()" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-8 px-4 bg-neutral-50 rounded-xl border border-neutral-200">
                            <svg class="w-10 h-10 mx-auto text-neutral-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <p class="text-neutral-500 text-sm font-medium">Belum ada siswa di kelas ini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Desktop View (Table) -->
                <div class="hidden md:block overflow-x-auto rounded-lg border border-neutral-200 mt-4">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                                <th class="p-4 font-bold w-1/2">Nama Siswa</th>
                                <th class="p-4 font-bold w-1/4">NIS</th>
                                <th class="p-4 font-bold text-right w-1/4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($classRoom->students as $student)
                                <tr class="hover:bg-primary-50/50 transition-colors group">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                                {{ substr($student->name, 0, 1) }}
                                            </div>
                                            <div class="font-bold text-neutral-800 text-sm group-hover:text-primary-700 transition-colors">{{ $student->name }}</div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm font-medium text-neutral-600">{{ $student->nis ?? '-' }}</td>
                                    <td class="p-4 text-right">
                                        <button wire:click="removeStudent({{ $student->id }})" onclick="confirm('Keluarkan siswa ini dari kelas?') || event.stopImmediatePropagation()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-red-700 hover:border-red-300 hover:bg-red-50 rounded-lg text-xs font-semibold transition-all shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Keluarkan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-neutral-500">
                                        <svg class="w-10 h-10 mx-auto text-neutral-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p class="font-medium">Belum ada siswa di kelas ini.</p>
                                    </td>
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
                
                <!-- Mobile View (Cards) -->
                <div class="block md:hidden p-2 space-y-3 mt-4">
                    @forelse($classRoom->teachers as $teacher)
                        <div class="bg-white rounded-xl border border-neutral-200 p-4 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center font-bold text-base flex-shrink-0">
                                    {{ substr($teacher->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-neutral-800 text-sm">{{ $teacher->name }}</h4>
                                    <div class="text-xs text-neutral-500 mt-0.5">NIP: <span class="font-medium text-neutral-600">{{ $teacher->nip ?? '-' }}</span></div>
                                </div>
                            </div>
                            <button wire:click="removeTeacher({{ $teacher->id }})" onclick="confirm('Hapus penugasan guru ini dari kelas?') || event.stopImmediatePropagation()" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-8 px-4 bg-neutral-50 rounded-xl border border-neutral-200">
                            <svg class="w-10 h-10 mx-auto text-neutral-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <p class="text-neutral-500 text-sm font-medium">Belum ada guru yang ditugaskan ke kelas ini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Desktop View (Table) -->
                <div class="hidden md:block overflow-x-auto rounded-lg border border-neutral-200 mt-4">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                                <th class="p-4 font-bold w-1/2">Nama Guru</th>
                                <th class="p-4 font-bold w-1/4">NIP</th>
                                <th class="p-4 font-bold text-right w-1/4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($classRoom->teachers as $teacher)
                                <tr class="hover:bg-primary-50/50 transition-colors group">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                                {{ substr($teacher->name, 0, 1) }}
                                            </div>
                                            <div class="font-bold text-neutral-800 text-sm group-hover:text-primary-700 transition-colors">{{ $teacher->name }}</div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm font-medium text-neutral-600">{{ $teacher->nip ?? '-' }}</td>
                                    <td class="p-4 text-right">
                                        <button wire:click="removeTeacher({{ $teacher->id }})" onclick="confirm('Hapus penugasan guru ini dari kelas?') || event.stopImmediatePropagation()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-red-700 hover:border-red-300 hover:bg-red-50 rounded-lg text-xs font-semibold transition-all shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-neutral-500">
                                        <svg class="w-10 h-10 mx-auto text-neutral-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p class="font-medium">Belum ada guru yang ditugaskan ke kelas ini.</p>
                                    </td>
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
                            <input type="checkbox" wire:model.live="selectedStudents" value="{{ $student->id }}" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500 w-5 h-5 mr-3">
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
                            <input type="checkbox" wire:model.live="selectedTeachers" value="{{ $teacher->id }}" class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500 w-5 h-5 mr-3">
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
