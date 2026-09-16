<div class="space-y-6">
    <!-- Modern Header Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-primary-400 opacity-20 blur-xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Manajemen Siswa Kelasku</h2>
            <p class="text-primary-100 font-medium mt-1">Kelola data dan pengajuan perubahan data siswa</p>
        </div>
        
        <div class="relative z-10 w-full lg:w-auto flex flex-col sm:flex-row flex-wrap gap-3 items-center mt-4 md:mt-0">
            <div class="relative w-full sm:w-56">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau NIS..." class="w-full pl-10 pr-3 py-2.5 rounded-xl border-0 bg-white/10 backdrop-blur-md text-white placeholder-white/70 text-sm focus:outline-none focus:ring-2 focus:ring-white/50 shadow-inner">
            </div>
            
            @if(count($classRooms) > 1)
                <select wire:model.live="filterClassId" class="w-full sm:w-auto rounded-xl border-0 bg-white/10 backdrop-blur-md text-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-white/50 font-bold shadow-inner">
                    @foreach($classRooms as $ac)
                        <option value="{{ $ac->id }}" class="text-neutral-800">{{ $ac->class_name }}</option>
                    @endforeach
                </select>
            @endif
            
            <div class="flex gap-2 w-full sm:w-auto justify-stretch">
                <button wire:click="exportCsv" class="flex-1 sm:flex-none bg-white text-blue-600 hover:bg-blue-50 px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    CSV
                </button>
                <button wire:click="exportPdf" class="flex-1 sm:flex-none bg-white text-red-600 hover:bg-red-50 px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    PDF
                </button>
            </div>
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

    <div class="md:bg-white md:rounded-xl md:shadow-sm md:overflow-hidden">
        <!-- Mobile View (Cards) -->
        <div class="block md:hidden space-y-4">
            @forelse($students as $student)
                @php
                    $pendingRequest = $student->changeRequests->first();
                @endphp
                <div class="bg-white rounded-2xl border border-neutral-100 p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <!-- Removed left border indicator, relying on badges instead -->
                    
                    <div class="flex justify-between items-start mb-4 border-b border-neutral-50 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base flex-shrink-0">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-neutral-800 text-sm">{{ $student->name }}</h4>
                                <div class="text-xs text-neutral-500 mt-0.5">NIS: <span class="font-medium text-neutral-600">{{ $student->nis ?? '-' }}</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-neutral-50 rounded-lg p-3 space-y-2 mb-4 border border-neutral-100 text-sm">
                        <div class="flex flex-col">
                            <span class="text-xs text-neutral-400 font-semibold mb-1">EMAIL:</span>
                            <span class="font-medium text-neutral-700 truncate">{{ $student->email }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <div>
                            @if($pendingRequest)
                                <span class="inline-flex items-center px-2 py-1 rounded bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-bold shadow-sm">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Menunggu Review
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200 text-xs font-bold shadow-sm">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Aktif
                                </span>
                            @endif
                        </div>
                        <button wire:click="openForm({{ $student->id }})" 
                                @if($pendingRequest) disabled @endif
                                class="flex justify-center items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm {{ $pendingRequest ? 'text-neutral-400 bg-neutral-100 border border-neutral-200 cursor-not-allowed opacity-70' : 'bg-white text-primary-700 hover:bg-primary-50 border border-primary-200' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 px-4 bg-neutral-50 rounded-xl border border-neutral-200">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <p class="text-neutral-500 font-medium">Belum ada siswa di kelas yang Anda ampu.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                        <th class="p-5 font-bold w-1/3">Nama Siswa</th>
                        <th class="p-5 font-bold w-1/6">NIS</th>
                        <th class="p-5 font-bold w-1/4">Email</th>
                        <th class="p-5 font-bold text-center w-1/6">Status Data</th>
                        <th class="p-5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($students as $student)
                        @php
                            $pendingRequest = $student->changeRequests->first();
                        @endphp
                        <tr class="hover:bg-primary-50/50 transition-colors group">
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-sm flex-shrink-0 group-hover:bg-primary-200 transition-colors">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <div class="font-bold text-neutral-800 text-sm group-hover:text-primary-700 transition-colors">{{ $student->name }}</div>
                                </div>
                            </td>
                            <td class="p-5 text-sm font-medium text-neutral-600">{{ $student->nis ?? '-' }}</td>
                            <td class="p-5 text-sm font-medium text-neutral-600">{{ $student->email }}</td>
                            <td class="p-5 text-center">
                                @if($pendingRequest)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 shadow-sm" title="Pengajuan sedang divalidasi Admin Sekolah">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Menunggu Review
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-5 text-right">
                                <button wire:click="openForm({{ $student->id }})" 
                                        @if($pendingRequest) disabled @endif
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm {{ $pendingRequest ? 'text-neutral-400 bg-neutral-50 border border-neutral-200 cursor-not-allowed opacity-75' : 'bg-white text-primary-700 border border-primary-200 hover:bg-primary-50 hover:border-primary-300' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Edit Data
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-neutral-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p class="font-bold text-lg text-neutral-700">Belum ada siswa</p>
                                    <p class="text-sm mt-1 text-neutral-500">Belum ada siswa di kelas yang Anda ampu.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-neutral-100">
            {{ $students->links() }}
        </div>
    </div>

    <!-- MODAL PENGAJUAN EDIT -->
    @if($isFormOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="backdrop-filter: blur(2px);">
        <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-1/2 max-w-lg overflow-hidden flex flex-col">
            <div class="flex justify-between items-center p-4 border-b bg-neutral-50">
                <h3 class="text-lg font-bold text-neutral-800">Ajukan Perubahan Data Siswa</h3>
                <button wire:click="closeForm" class="text-neutral-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form wire:submit="submitChangeRequest" class="p-6 space-y-4">
                <div class="bg-blue-50 text-blue-800 text-xs p-3 rounded border border-blue-200 mb-4">
                    <p><strong>Info:</strong> Perubahan yang Anda simpan di sini tidak akan langsung mengubah data siswa. Sistem akan mengirimkan "Pengajuan" ke Admin Sekolah untuk divalidasi terlebih dahulu.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">NIS (Nomor Induk Siswa)</label>
                    <input type="text" wire:model="nis" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    @error('nis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
                    <input type="email" wire:model="email" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Catatan/Alasan Perubahan (Opsional)</label>
                    <textarea wire:model="notes" rows="2" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Mengapa data ini diubah?"></textarea>
                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t mt-4">
                    <button type="button" wire:click="closeForm" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 text-sm hover:bg-neutral-100 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
