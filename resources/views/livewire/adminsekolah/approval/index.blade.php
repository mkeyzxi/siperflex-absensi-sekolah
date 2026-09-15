<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h2 class="text-2xl font-bold text-neutral-800">Persetujuan Perubahan Data Siswa</h2>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="flex border-b border-neutral-200 bg-neutral-50">
            <button wire:click="setTab('pending')" class="px-6 py-3 text-sm font-bold border-b-2 transition-colors {{ $activeTab === 'pending' ? 'border-primary-600 text-primary-600 bg-white' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100' }}">
                Menunggu Persetujuan
            </button>
            <button wire:click="setTab('approved')" class="px-6 py-3 text-sm font-bold border-b-2 transition-colors {{ $activeTab === 'approved' ? 'border-primary-600 text-primary-600 bg-white' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100' }}">
                Disetujui
            </button>
            <button wire:click="setTab('rejected')" class="px-6 py-3 text-sm font-bold border-b-2 transition-colors {{ $activeTab === 'rejected' ? 'border-primary-600 text-primary-600 bg-white' : 'border-transparent text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100' }}">
                Ditolak
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-600 text-xs uppercase tracking-wider border-b border-neutral-200">
                        <th class="p-4 font-semibold">Tanggal & Guru</th>
                        <th class="p-4 font-semibold">Siswa (Data Saat Ini)</th>
                        <th class="p-4 font-semibold">Perubahan (Request)</th>
                        <th class="p-4 font-semibold text-right">Aksi / Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse($requests as $req)
                        <tr class="hover:bg-neutral-50">
                            <td class="p-4 align-top">
                                <div class="font-medium text-neutral-800">{{ $req->teacher->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-neutral-500">{{ $req->created_at->format('d M Y, H:i') }}</div>
                                @if($req->notes && $req->status === 'pending')
                                    <div class="mt-2 text-xs bg-yellow-50 text-yellow-800 border border-yellow-200 p-2 rounded">
                                        <strong>Catatan Guru:</strong> {{ $req->notes }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 align-top">
                                <div class="font-medium text-neutral-800">{{ $req->student->name ?? '-' }}</div>
                                <div class="text-sm text-neutral-500">NIS: {{ $req->student->nis ?? '-' }}</div>
                                <div class="text-sm text-neutral-500">{{ $req->student->email ?? '-' }}</div>
                            </td>
                            <td class="p-4 align-top">
                                @php
                                    $newData = $req->requested_data;
                                    $student = $req->student;
                                @endphp
                                <div class="text-sm space-y-1">
                                    @if(isset($newData['name']) && $newData['name'] !== $student->name)
                                        <div><span class="text-neutral-400">Nama:</span> <span class="font-medium text-green-600">{{ $newData['name'] }}</span></div>
                                    @endif
                                    @if(isset($newData['nis']) && $newData['nis'] !== $student->nis)
                                        <div><span class="text-neutral-400">NIS:</span> <span class="font-medium text-green-600">{{ $newData['nis'] }}</span></div>
                                    @endif
                                    @if(isset($newData['email']) && $newData['email'] !== $student->email)
                                        <div><span class="text-neutral-400">Email:</span> <span class="font-medium text-green-600">{{ $newData['email'] }}</span></div>
                                    @endif
                                    
                                    @if(
                                        (!isset($newData['name']) || $newData['name'] === $student->name) &&
                                        (!isset($newData['nis']) || $newData['nis'] === $student->nis) &&
                                        (!isset($newData['email']) || $newData['email'] === $student->email)
                                    )
                                        <span class="italic text-neutral-400">Tidak ada perubahan field</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 align-top text-right space-y-2">
                                @if($req->status === 'pending')
                                    <button wire:click="openApprovalModal({{ $req->id }}, 'approve')" class="px-3 py-1 bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 text-xs font-bold rounded shadow-sm block w-full text-center transition-colors">
                                        Setujui
                                    </button>
                                    <button wire:click="openApprovalModal({{ $req->id }}, 'reject')" class="px-3 py-1 bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 text-xs font-bold rounded shadow-sm block w-full text-center transition-colors">
                                        Tolak
                                    </button>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $req->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                    @if($req->admin)
                                        <div class="text-[10px] text-neutral-500 mt-1">oleh: {{ $req->admin->name }}</div>
                                    @endif
                                    @if($req->notes && $req->status === 'rejected')
                                        <div class="text-xs text-red-600 mt-1" title="{{ $req->notes }}">Alasan: {{ Str::limit($req->notes, 30) }}</div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-neutral-500">
                                Tidak ada pengajuan perubahan data di tab ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-neutral-100">
            {{ $requests->links() }}
        </div>
    </div>

    <!-- MODAL APPROVAL / REJECTION -->
    @if($showApprovalModal && $selectedRequest)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="backdrop-filter: blur(2px);">
        <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-1/3 max-w-md overflow-hidden flex flex-col">
            <div class="flex justify-between items-center p-4 border-b bg-neutral-50">
                <h3 class="text-lg font-bold {{ $actionType === 'approve' ? 'text-green-700' : 'text-red-700' }}">
                    {{ $actionType === 'approve' ? 'Setujui Perubahan' : 'Tolak Perubahan' }}
                </h3>
                <button wire:click="closeApprovalModal" class="text-neutral-500 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <p class="text-sm text-neutral-700 mb-4">
                    Anda akan <strong>{{ $actionType === 'approve' ? 'menyetujui' : 'menolak' }}</strong> perubahan data untuk siswa <strong>{{ $selectedRequest->student->name }}</strong> yang diajukan oleh Guru <strong>{{ $selectedRequest->teacher->name }}</strong>.
                </p>

                @if($actionType === 'reject')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea wire:model="adminNotes" rows="3" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Beritahu guru alasan data ini ditolak..."></textarea>
                        @error('adminNotes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @else
                    <!-- Approve, notes are optional but could be useful -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-neutral-700 mb-1">Catatan Tambahan (Opsional)</label>
                        <input type="text" wire:model="adminNotes" class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Oke, sudah disetujui...">
                    </div>
                @endif
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button wire:click="closeApprovalModal" class="px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 text-sm hover:bg-neutral-100 transition-colors">Batal</button>
                    <button wire:click="processRequest" class="px-4 py-2 text-white rounded-lg text-sm font-medium transition-colors {{ $actionType === 'approve' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}">
                        Konfirmasi {{ $actionType === 'approve' ? 'Setuju' : 'Tolak' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
