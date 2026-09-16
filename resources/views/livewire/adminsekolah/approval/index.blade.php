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

        <!-- Mobile View (Cards) -->
        <div class="block md:hidden space-y-4">
            @forelse($requests as $req)
                <div class="bg-white rounded-2xl border border-neutral-100 p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <!-- Removed left border indicator, relying on modern card design -->
                    
                    <!-- Header: Guru & Date -->
                    <div class="flex justify-between items-start mb-4 border-b border-neutral-50 pb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                {{ substr($req->teacher->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div class="text-xs text-neutral-500">Diajukan oleh:</div>
                                <div class="font-bold text-neutral-800 text-sm">{{ $req->teacher->name ?? 'Unknown' }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-[10px] text-neutral-400 font-medium bg-neutral-50 px-2 py-1 rounded border border-neutral-100">
                                {{ $req->created_at->format('d M, H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Student Info -->
                    <div class="mb-3">
                        <h4 class="font-bold text-neutral-800 flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $req->student->name ?? '-' }}
                        </h4>
                        <div class="text-xs text-neutral-500 ml-6">NIS: {{ $req->student->nis ?? '-' }}</div>
                    </div>

                    <!-- Requested Changes -->
                    <div class="bg-primary-50/50 rounded-lg p-3 border border-primary-100 mb-4">
                        <div class="text-xs font-semibold text-primary-800 mb-2 border-b border-primary-200/50 pb-1">Perubahan yang diajukan:</div>
                        @php
                            $newData = $req->requested_data;
                            $student = $req->student;
                        @endphp
                        <div class="text-xs space-y-1.5">
                            @if(isset($newData['name']) && $newData['name'] !== $student->name)
                                <div class="grid grid-cols-3 gap-1"><span class="text-neutral-500">Nama:</span> <span class="font-semibold text-green-700 col-span-2">{{ $newData['name'] }}</span></div>
                            @endif
                            @if(isset($newData['nis']) && $newData['nis'] !== $student->nis)
                                <div class="grid grid-cols-3 gap-1"><span class="text-neutral-500">NIS:</span> <span class="font-semibold text-green-700 col-span-2">{{ $newData['nis'] }}</span></div>
                            @endif
                            @if(isset($newData['email']) && $newData['email'] !== $student->email)
                                <div class="grid grid-cols-3 gap-1"><span class="text-neutral-500">Email:</span> <span class="font-semibold text-green-700 col-span-2">{{ $newData['email'] }}</span></div>
                            @endif
                            
                            @if(
                                (!isset($newData['name']) || $newData['name'] === $student->name) &&
                                (!isset($newData['nis']) || $newData['nis'] === $student->nis) &&
                                (!isset($newData['email']) || $newData['email'] === $student->email)
                            )
                                <span class="italic text-neutral-400 block pt-1">Tidak ada perubahan field</span>
                            @endif
                        </div>
                    </div>

                    @if($req->notes && $req->status === 'pending')
                        <div class="mb-4 text-xs bg-yellow-50 text-yellow-800 border border-yellow-200 p-2.5 rounded-lg shadow-sm">
                            <strong>Catatan Guru:</strong> <span class="italic">{{ $req->notes }}</span>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="border-t border-neutral-100 pt-3">
                        @if($req->status === 'pending')
                            <div class="grid grid-cols-2 gap-2">
                                <button wire:click="openApprovalModal({{ $req->id }}, 'reject')" class="flex justify-center items-center gap-1.5 py-2 bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 text-sm font-bold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Tolak
                                </button>
                                <button wire:click="openApprovalModal({{ $req->id }}, 'approve')" class="flex justify-center items-center gap-1.5 py-2 bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 text-sm font-bold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Setujui
                                </button>
                            </div>
                        @else
                            <div class="flex items-center justify-between bg-neutral-50 px-3 py-2 rounded-lg border border-neutral-200">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold shadow-sm {{ $req->status === 'approved' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                    @if($req->status === 'approved')
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                    {{ ucfirst($req->status) }}
                                </span>
                                @if($req->admin)
                                    <div class="text-[10px] text-neutral-500 font-medium">oleh: {{ $req->admin->name }}</div>
                                @endif
                            </div>
                            @if($req->notes && $req->status === 'rejected')
                                <div class="text-xs text-red-600 mt-2 bg-red-50 p-2 rounded border border-red-100"><strong>Alasan:</strong> {{ $req->notes }}</div>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10 px-4 bg-neutral-50 rounded-xl border border-neutral-200">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-neutral-500 font-medium">Tidak ada pengajuan perubahan data di tab ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50 text-neutral-500 text-xs uppercase tracking-widest border-b border-neutral-200">
                        <th class="p-5 font-bold">Tanggal & Guru</th>
                        <th class="p-5 font-bold">Siswa (Data Saat Ini)</th>
                        <th class="p-5 font-bold">Perubahan (Request)</th>
                        <th class="p-5 font-bold text-right">Aksi / Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($requests as $req)
                        <tr class="hover:bg-primary-50/50 transition-colors group">
                            <td class="p-5 align-top">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-600 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5 shadow-sm border border-neutral-200">
                                        {{ substr($req->teacher->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-neutral-800 text-sm group-hover:text-primary-700 transition-colors">{{ $req->teacher->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-neutral-500 mt-0.5 font-medium flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $req->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                                @if($req->notes && $req->status === 'pending')
                                    <div class="mt-3 text-xs bg-yellow-50 text-yellow-800 border border-yellow-200 p-2.5 rounded-lg shadow-sm">
                                        <strong class="block mb-0.5">Catatan Guru:</strong> <span class="italic">"{{ $req->notes }}"</span>
                                    </div>
                                @endif
                            </td>
                            <td class="p-5 align-top">
                                <div class="font-bold text-neutral-800 text-sm mb-1 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ $req->student->name ?? '-' }}
                                </div>
                                <div class="text-xs text-neutral-500 font-medium ml-5.5">NIS: {{ $req->student->nis ?? '-' }}</div>
                                <div class="text-xs text-neutral-500 font-medium ml-5.5">{{ $req->student->email ?? '-' }}</div>
                            </td>
                            <td class="p-5 align-top">
                                @php
                                    $newData = $req->requested_data;
                                    $student = $req->student;
                                @endphp
                                <div class="bg-white border border-neutral-200 rounded-lg p-3 shadow-sm text-sm space-y-1.5">
                                    @if(isset($newData['name']) && $newData['name'] !== $student->name)
                                        <div class="flex"><span class="text-neutral-500 w-16">Nama:</span> <span class="font-bold text-green-600">{{ $newData['name'] }}</span></div>
                                    @endif
                                    @if(isset($newData['nis']) && $newData['nis'] !== $student->nis)
                                        <div class="flex"><span class="text-neutral-500 w-16">NIS:</span> <span class="font-bold text-green-600">{{ $newData['nis'] }}</span></div>
                                    @endif
                                    @if(isset($newData['email']) && $newData['email'] !== $student->email)
                                        <div class="flex"><span class="text-neutral-500 w-16">Email:</span> <span class="font-bold text-green-600">{{ $newData['email'] }}</span></div>
                                    @endif
                                    
                                    @if(
                                        (!isset($newData['name']) || $newData['name'] === $student->name) &&
                                        (!isset($newData['nis']) || $newData['nis'] === $student->nis) &&
                                        (!isset($newData['email']) || $newData['email'] === $student->email)
                                    )
                                        <span class="italic text-neutral-400 text-xs">Tidak ada perubahan field</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-5 align-top text-right space-y-2">
                                @if($req->status === 'pending')
                                    <button wire:click="openApprovalModal({{ $req->id }}, 'approve')" class="px-4 py-2 bg-green-50 text-green-700 hover:bg-green-100 hover:border-green-300 border border-green-200 text-xs font-bold rounded-lg shadow-sm block w-full text-center transition-all flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setujui
                                    </button>
                                    <button wire:click="openApprovalModal({{ $req->id }}, 'reject')" class="px-4 py-2 bg-red-50 text-red-700 hover:bg-red-100 hover:border-red-300 border border-red-200 text-xs font-bold rounded-lg shadow-sm block w-full text-center transition-all flex items-center justify-center gap-1.5 mt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tolak
                                    </button>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm border {{ $req->status === 'approved' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                        @if($req->status === 'approved')
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        @endif
                                        {{ ucfirst($req->status) }}
                                    </span>
                                    @if($req->admin)
                                        <div class="text-[10px] text-neutral-500 mt-2 font-medium bg-neutral-50 px-2 py-1 rounded inline-block border border-neutral-100">oleh: {{ $req->admin->name }}</div>
                                    @endif
                                    @if($req->notes && $req->status === 'rejected')
                                        <div class="text-xs text-red-600 mt-2 p-2 bg-red-50 border border-red-100 rounded text-left" title="{{ $req->notes }}"><strong>Alasan:</strong> {{ Str::limit($req->notes, 40) }}</div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-neutral-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="font-bold text-lg text-neutral-700">Tidak ada pengajuan</p>
                                    <p class="text-sm mt-1 text-neutral-500">Belum ada pengajuan perubahan data di tab ini.</p>
                                </div>
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
