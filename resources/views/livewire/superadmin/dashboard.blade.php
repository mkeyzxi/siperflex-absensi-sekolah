<div class="space-y-6">
    <!-- Modern Header Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg p-6 md:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-primary-400 opacity-20 blur-xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Manajemen Sekolah</h2>
            <p class="text-primary-100 font-medium mt-1">Kelola data sekolah yang terdaftar di sistem</p>
        </div>
        
        <div class="relative z-10 w-full sm:w-auto mt-4 sm:mt-0 text-left sm:text-right">
            <button wire:click="openForm" class="bg-white text-primary-700 hover:bg-primary-50 px-5 py-2.5 rounded-xl font-bold shadow-lg transition-colors flex items-center gap-2 w-full sm:w-auto justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Sekolah
            </button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm" role="alert">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($isFormOpen)
        <div class="bg-white rounded-2xl shadow-md border border-neutral-100 p-6 md:p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-500 to-primary-300"></div>
            <h3 class="text-xl font-bold text-neutral-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                {{ $isEditing ? 'Edit Data Sekolah' : 'Tambah Sekolah Baru' }}
            </h3>
            
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Nama Sekolah <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="name" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Kode Sekolah (Unik) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="code" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">NPSN</label>
                        <input type="text" wire:model="npsn" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Email Sekolah <span class="text-red-500">*</span></label>
                        <input type="email" wire:model="email" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Telepon <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="phone" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Status Aktif</label>
                        <select wire:model="is_active" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea wire:model="address" rows="3" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" required></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" wire:click="closeForm" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 hover:bg-neutral-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
                        Simpan Sekolah
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Mobile View (Cards) -->
        <div class="block md:hidden p-4 space-y-4">
            @forelse($schools as $school)
                <div class="bg-white rounded-xl border border-neutral-200 p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-neutral-800 text-lg">{{ $school->name }}</h4>
                            <div class="text-xs text-neutral-500 mt-1">Kode: <span class="font-semibold">{{ $school->code }}</span> | NPSN: {{ $school->npsn ?? '-' }}</div>
                        </div>
                        <div>
                            @if($school->is_active)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="bg-neutral-50 rounded-lg p-3 space-y-2 mb-4 border border-neutral-100">
                        <div class="flex items-center text-sm text-neutral-700">
                            <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="truncate">{{ $school->email }}</span>
                        </div>
                        <div class="flex items-center text-sm text-neutral-700">
                            <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $school->phone }}</span>
                        </div>
                    </div>
                    
                    <button wire:click="openForm({{ $school->id }})" class="w-full flex justify-center items-center gap-2 bg-primary-50 text-primary-700 hover:bg-primary-100 hover:text-primary-800 py-2.5 rounded-lg text-sm font-semibold transition-colors border border-primary-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Sekolah
                    </button>
                </div>
            @empty
                <div class="text-center py-8 px-4 bg-neutral-50 rounded-xl border border-neutral-200">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <p class="text-neutral-500 font-medium">Belum ada data sekolah.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                        <th class="p-5 font-bold w-2/5">Informasi Sekolah</th>
                        <th class="p-5 font-bold w-1/4">Kontak</th>
                        <th class="p-5 font-bold text-center w-1/6">Status</th>
                        <th class="p-5 font-bold text-right w-1/6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($schools as $school)
                        <tr class="hover:bg-primary-50/50 transition-colors group">
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                                        {{ substr($school->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-neutral-800 text-base group-hover:text-primary-700 transition-colors">{{ $school->name }}</div>
                                        <div class="text-xs text-neutral-500 mt-0.5">NPSN: <span class="font-medium text-neutral-600">{{ $school->npsn ?? '-' }}</span> &bull; Kode: <span class="font-medium text-neutral-600">{{ $school->code }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="space-y-1.5">
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        {{ $school->email }}
                                    </div>
                                    <div class="flex items-center text-sm text-neutral-600">
                                        <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $school->phone }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                @if($school->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200 shadow-sm">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-5 text-right">
                                <button wire:click="openForm({{ $school->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-primary-700 hover:border-primary-300 hover:bg-primary-50 rounded-lg text-sm font-semibold transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-neutral-500">
                                <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <p class="text-neutral-500 font-medium">Belum ada data sekolah.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-neutral-200">
            {{ $schools->links() }}
        </div>
    </div>
</div>
