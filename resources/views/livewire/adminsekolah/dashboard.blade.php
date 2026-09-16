<div class="space-y-6 md:pb-6 pb-20">
    <!-- Modern Header Card -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-none md:rounded-2xl shadow-lg p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
        <!-- Abstract Background Decoration -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-primary-400 opacity-20 blur-xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Manajemen Pengguna</h2>
            <p class="text-primary-100 font-medium mt-1">Kelola data guru dan siswa di sekolah Anda</p>
        </div>
        
        <div class="relative z-10 w-full md:w-auto">
            <div class="flex rounded-xl shadow-lg bg-white/10 backdrop-blur-md border border-white/20 p-1">
                <button wire:click="setTab('guru')" class="flex-1 md:flex-none px-6 py-2.5 text-sm font-bold rounded-lg transition-all {{ $activeTab === 'guru' ? 'bg-white text-primary-700 shadow' : 'text-white hover:bg-white/20' }}">
                    Data Guru
                </button>
                <button wire:click="setTab('siswa')" class="flex-1 md:flex-none px-6 py-2.5 text-sm font-bold rounded-lg transition-all {{ $activeTab === 'siswa' ? 'bg-white text-primary-700 shadow' : 'text-white hover:bg-white/20' }}">
                    Data Siswa
                </button>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative shadow-sm mx-4 md:mx-0 mb-6" role="alert">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Content Container: Transparent on Mobile, White Card on Desktop -->
    <div class="md:bg-white md:rounded-2xl md:shadow-sm md:p-6 md:border md:border-neutral-100">
        
        <!-- Action Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 md:mb-6 px-4 md:px-0">
            <h3 class="text-xl font-bold text-neutral-800">Daftar {{ ucfirst($activeTab) }}</h3>
            <div class="flex flex-col sm:flex-row w-full sm:w-auto gap-3">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari {{ $activeTab }}..." class="w-full pl-10 pr-3 py-2.5 bg-white md:bg-neutral-50 border border-neutral-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all shadow-sm md:shadow-none">
                </div>
                <button wire:click="openForm" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-md transition-colors w-full sm:w-auto flex justify-center items-center gap-2 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah {{ ucfirst($activeTab) }}
                </button>
            </div>
        </div>

        <!-- Form Modal (Fixes Mobile UX scrolling issue) -->
        @if($isFormOpen)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-neutral-900/60 backdrop-blur-sm" wire:click="closeForm"></div>
                
                <!-- Modal Content -->
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl relative overflow-hidden z-10 flex flex-col max-h-[90vh]">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-500 to-primary-300"></div>
                    
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center p-5 md:p-6 border-b border-neutral-100 flex-shrink-0">
                        <h4 class="font-bold text-lg md:text-xl text-neutral-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            {{ $isEditing ? 'Edit Data ' . ucfirst($activeTab) : 'Tambah Data Baru' }}
                        </h4>
                        <button type="button" wire:click="closeForm" class="text-neutral-400 hover:text-neutral-600 transition-colors p-1 rounded-lg hover:bg-neutral-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Modal Body (Scrollable) -->
                    <div class="p-5 md:p-6 overflow-y-auto">
                        <form wire:submit="save" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-1">Nama Lengkap</label>
                                    <input type="text" wire:model="name" class="w-full rounded-xl border border-neutral-300 px-3 py-2.5 focus:border-primary-500 focus:ring focus:ring-primary-200 transition-all" required>
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-1">Username</label>
                                    <input type="text" wire:model="username" class="w-full rounded-xl border border-neutral-300 px-3 py-2.5 focus:border-primary-500 focus:ring focus:ring-primary-200 transition-all" required>
                                    @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
                                    <input type="email" wire:model="email" class="w-full rounded-xl border border-neutral-300 px-3 py-2.5 focus:border-primary-500 focus:ring focus:ring-primary-200 transition-all" required>
                                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-1">{{ $activeTab === 'guru' ? 'NIP' : 'NIS' }}</label>
                                    <input type="text" wire:model="identifier" class="w-full rounded-xl border border-neutral-300 px-3 py-2.5 focus:border-primary-500 focus:ring focus:ring-primary-200 transition-all" required>
                                    @error('identifier') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-neutral-700 mb-1">Password {{ $isEditing ? '(Kosongkan jika tidak ingin diubah)' : '' }}</label>
                                    <input type="password" wire:model="password" class="w-full rounded-xl border border-neutral-300 px-3 py-2.5 focus:border-primary-500 focus:ring focus:ring-primary-200 transition-all" {{ $isEditing ? '' : 'required' }}>
                                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <!-- Modal Footer -->
                            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 mt-6 border-t border-neutral-100">
                                <button type="button" wire:click="closeForm" class="w-full sm:w-auto px-5 py-2.5 border border-neutral-300 rounded-xl text-neutral-700 font-medium text-sm hover:bg-neutral-50 transition-colors">Batal</button>
                                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-bold shadow-md transition-colors">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Mobile View (Compact List Cards) -->
        <div class="block md:hidden px-4 space-y-3">
            @forelse($users as $user)
                <div class="bg-white rounded-xl border border-neutral-200 p-4 shadow-sm flex flex-col gap-3 relative hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-base flex-shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-neutral-800 text-sm leading-tight truncate">{{ $user->name }}</h4>
                                <div class="text-xs text-neutral-500 mt-1 truncate">@ {{ $user->username }}</div>
                                <div class="text-xs font-medium text-neutral-600 mt-1">{{ $activeTab === 'guru' ? 'NIP' : 'NIS' }}: {{ $activeTab === 'guru' ? ($user->nip ?? '-') : ($user->nis ?? '-') }}</div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-2 flex-shrink-0">
                            <button wire:click="openForm({{ $user->id }})" class="p-2 text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-lg transition-colors border border-primary-100" aria-label="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button wire:click="delete({{ $user->id }})" onclick="confirm('Yakin ingin menghapus pengguna ini?') || event.stopImmediatePropagation()" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors border border-red-100" aria-label="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 px-4 bg-white md:bg-neutral-50 rounded-xl border border-neutral-200">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <p class="text-neutral-500 font-medium">Belum ada data {{ $activeTab }}.</p>
                </div>
            @endforelse
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto mt-2">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                        <th class="p-5 font-bold w-2/5">Informasi Pengguna</th>
                        <th class="p-5 font-bold w-1/5">{{ $activeTab === 'guru' ? 'NIP' : 'NIS' }}</th>
                        <th class="p-5 font-bold w-1/4">Kontak</th>
                        <th class="p-5 font-bold text-right w-1/6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-primary-50/50 transition-colors group">
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-neutral-800 text-base group-hover:text-primary-700 transition-colors">{{ $user->name }}</div>
                                        <div class="text-xs text-neutral-500 mt-0.5">Username: <span class="font-medium text-neutral-600">{{ $user->username }}</span></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="font-semibold text-neutral-700">
                                    {{ $activeTab === 'guru' ? ($user->nip ?? '-') : ($user->nis ?? '-') }}
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center text-sm text-neutral-600">
                                    <svg class="w-4 h-4 mr-2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $user->email }}
                                </div>
                            </td>
                            <td class="p-5 text-right space-x-2">
                                <button wire:click="openForm({{ $user->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-primary-700 hover:border-primary-300 hover:bg-primary-50 rounded-lg text-sm font-semibold transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </button>
                                <button wire:click="delete({{ $user->id }})" onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-neutral-200 text-neutral-700 hover:text-red-700 hover:border-red-300 hover:bg-red-50 rounded-lg text-sm font-semibold transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-neutral-500">
                                <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="text-neutral-500 font-medium">Belum ada data {{ $activeTab }}.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
