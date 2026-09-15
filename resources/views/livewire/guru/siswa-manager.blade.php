<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h2 class="text-2xl font-bold text-neutral-800">Manajemen Siswa Kelasku</h2>
        <div class="flex flex-wrap gap-2 items-center">
            @if(count($classRooms) > 1)
                <select wire:model.live="filterClassId" class="rounded-md border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 font-medium">
                    @foreach($classRooms as $ac)
                        <option value="{{ $ac->id }}">{{ $ac->class_name }}</option>
                    @endforeach
                </select>
            @endif
            
            <button wire:click="exportCsv" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export CSV
            </button>
            <button wire:click="exportPdf" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export PDF
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

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-600 text-xs uppercase tracking-wider border-b border-neutral-200">
                        <th class="p-4 font-semibold">Nama Siswa</th>
                        <th class="p-4 font-semibold">NIS</th>
                        <th class="p-4 font-semibold">Email</th>
                        <th class="p-4 font-semibold text-center">Status Data</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse($students as $student)
                        @php
                            $pendingRequest = $student->changeRequests->first();
                        @endphp
                        <tr class="hover:bg-neutral-50">
                            <td class="p-4">
                                <div class="font-medium text-neutral-800">{{ $student->name }}</div>
                            </td>
                            <td class="p-4 text-neutral-600">{{ $student->nis ?? '-' }}</td>
                            <td class="p-4 text-neutral-600">{{ $student->email }}</td>
                            <td class="p-4 text-center">
                                @if($pendingRequest)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800" title="Pengajuan sedang divalidasi Admin Sekolah">
                                        Menunggu Persetujuan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <button wire:click="openForm({{ $student->id }})" 
                                        @if($pendingRequest) disabled @endif
                                        class="text-sm font-medium transition-colors px-3 py-1 rounded border {{ $pendingRequest ? 'text-neutral-400 border-neutral-200 bg-neutral-50 cursor-not-allowed' : 'text-primary-600 border-primary-200 hover:bg-primary-50' }}">
                                    Edit Data
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-neutral-500">
                                <p>Belum ada siswa di kelas yang Anda ampu.</p>
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
