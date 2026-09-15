<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h2 class="text-2xl font-bold text-neutral-800">Manajemen Pengguna Sekolah</h2>
        
        <div class="flex rounded-lg shadow-sm border border-neutral-200 overflow-hidden">
            <button wire:click="setTab('guru')" class="px-4 py-2 text-sm font-medium {{ $activeTab === 'guru' ? 'bg-primary-600 text-white' : 'bg-white text-neutral-600 hover:bg-neutral-50' }} transition-colors">
                Guru
            </button>
            <button wire:click="setTab('siswa')" class="px-4 py-2 text-sm font-medium border-l border-neutral-200 {{ $activeTab === 'siswa' ? 'bg-primary-600 text-white' : 'bg-white text-neutral-600 hover:bg-neutral-50' }} transition-colors">
                Siswa
            </button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-neutral-800">Daftar {{ ucfirst($activeTab) }}</h3>
            <button wire:click="openForm" class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow-sm transition-colors">
                + Tambah {{ ucfirst($activeTab) }}
            </button>
        </div>

        @if($isFormOpen)
            <div class="mb-6 p-5 border border-neutral-200 rounded-lg bg-neutral-50">
                <h4 class="font-bold text-neutral-800 mb-4">{{ $isEditing ? 'Edit Data' : 'Tambah Data Baru' }}</h4>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full rounded-md border border-neutral-300 px-3 py-2" required>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Username</label>
                            <input type="text" wire:model="username" class="w-full rounded-md border border-neutral-300 px-3 py-2" required>
                            @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Email</label>
                            <input type="email" wire:model="email" class="w-full rounded-md border border-neutral-300 px-3 py-2" required>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">{{ $activeTab === 'guru' ? 'NIP' : 'NIS' }}</label>
                            <input type="text" wire:model="identifier" class="w-full rounded-md border border-neutral-300 px-3 py-2" required>
                            @error('identifier') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Password {{ $isEditing ? '(Kosongkan jika tidak ingin diubah)' : '' }}</label>
                            <input type="password" wire:model="password" class="w-full rounded-md border border-neutral-300 px-3 py-2" {{ $isEditing ? '' : 'required' }}>
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-2">
                        <button type="button" wire:click="closeForm" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium">Simpan</button>
                    </div>
                </form>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-600 text-sm uppercase tracking-wider border-b border-neutral-200">
                        <th class="p-3 font-semibold">Nama</th>
                        <th class="p-3 font-semibold">{{ $activeTab === 'guru' ? 'NIP' : 'NIS' }}</th>
                        <th class="p-3 font-semibold">Kontak</th>
                        <th class="p-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-neutral-50">
                            <td class="p-3">
                                <div class="font-bold text-neutral-800">{{ $user->name }}</div>
                                <div class="text-xs text-neutral-500">{{ $user->username }}</div>
                            </td>
                            <td class="p-3 text-neutral-700">
                                {{ $activeTab === 'guru' ? ($user->nip ?? '-') : ($user->nis ?? '-') }}
                            </td>
                            <td class="p-3 text-sm text-neutral-600">
                                {{ $user->email }}
                            </td>
                            <td class="p-3 text-right space-x-3">
                                <button wire:click="openForm({{ $user->id }})" class="text-primary-600 hover:text-primary-800 text-sm font-medium">Edit</button>
                                <button wire:click="delete({{ $user->id }})" onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-neutral-500">Belum ada data {{ $activeTab }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
