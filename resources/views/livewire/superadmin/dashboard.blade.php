<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-neutral-800">Manajemen Sekolah</h2>
        <button wire:click="openForm" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition-colors">
            + Tambah Sekolah
        </button>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($isFormOpen)
        <div class="bg-white rounded-xl shadow-sm p-6 border-t-4 border-primary-500">
            <h3 class="text-lg font-bold text-neutral-800 mb-4">{{ $isEditing ? 'Edit Sekolah' : 'Tambah Sekolah Baru' }}</h3>
            
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
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-600 text-sm uppercase tracking-wider border-b border-neutral-200">
                        <th class="p-4 font-semibold">Nama & Kode</th>
                        <th class="p-4 font-semibold">Kontak</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse($schools as $school)
                        <tr class="hover:bg-neutral-50">
                            <td class="p-4">
                                <div class="font-bold text-neutral-800">{{ $school->name }}</div>
                                <div class="text-xs text-neutral-500">NPSN: {{ $school->npsn ?? '-' }} | Kode: {{ $school->code }}</div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm text-neutral-700">{{ $school->email }}</div>
                                <div class="text-sm text-neutral-500">{{ $school->phone }}</div>
                            </td>
                            <td class="p-4 text-center">
                                @if($school->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <button wire:click="openForm({{ $school->id }})" class="text-primary-600 hover:text-primary-800 font-medium text-sm">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-neutral-500">Belum ada data sekolah.</td>
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
