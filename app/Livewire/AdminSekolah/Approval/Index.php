<?php

namespace App\Livewire\AdminSekolah\Approval;

use App\Models\StudentChangeRequest;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $activeTab = 'pending'; // 'pending', 'approved', 'rejected'
    
    // Approval modal
    public $showApprovalModal = false;
    public $selectedRequest = null;
    public $adminNotes = '';
    public $actionType = ''; // 'approve' or 'reject'

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function openApprovalModal($requestId, $action)
    {
        $this->selectedRequest = StudentChangeRequest::with(['student', 'teacher'])->findOrFail($requestId);
        
        // Ensure request is from same school
        if ($this->selectedRequest->student->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $this->actionType = $action;
        $this->adminNotes = '';
        $this->showApprovalModal = true;
    }

    public function closeApprovalModal()
    {
        $this->showApprovalModal = false;
        $this->selectedRequest = null;
        $this->adminNotes = '';
    }

    public function processRequest()
    {
        if (!$this->selectedRequest) return;

        if ($this->actionType === 'approve') {
            DB::transaction(function () {
                // Update User Data
                $student = User::findOrFail($this->selectedRequest->student_id);
                $newData = $this->selectedRequest->requested_data;
                
                $student->update([
                    'name' => $newData['name'] ?? $student->name,
                    'nis' => $newData['nis'] ?? $student->nis,
                    'email' => $newData['email'] ?? $student->email,
                ]);

                // Update Request Status
                $this->selectedRequest->update([
                    'status' => 'approved',
                    'admin_id' => auth()->id(),
                    'notes' => $this->adminNotes,
                ]);
            });

            session()->flash('success', 'Perubahan data siswa disetujui dan telah diperbarui.');
        } elseif ($this->actionType === 'reject') {
            if (empty(trim($this->adminNotes))) {
                $this->addError('adminNotes', 'Alasan penolakan wajib diisi.');
                return;
            }

            $this->selectedRequest->update([
                'status' => 'rejected',
                'admin_id' => auth()->id(),
                'notes' => $this->adminNotes,
            ]);

            session()->flash('success', 'Pengajuan perubahan data siswa ditolak.');
        }

        $this->closeApprovalModal();
    }

    public function render()
    {
        $school_id = auth()->user()->school_id;

        $requests = StudentChangeRequest::with(['student', 'teacher', 'admin'])
            ->whereHas('student', function ($query) use ($school_id) {
                $query->where('school_id', $school_id);
            })
            ->where('status', $this->activeTab)
            ->latest()
            ->paginate(10);

        return view('livewire.adminsekolah.approval.index', compact('requests'));
    }
}
