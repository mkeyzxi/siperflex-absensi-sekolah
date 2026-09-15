<?php

namespace App\Livewire\Guru;

use App\Models\StudentChangeRequest;
use App\Models\User;
use App\Models\ClassRoom;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('components.layouts.admin')]
class SiswaManager extends Component
{
    use WithPagination;

    public $isFormOpen = false;
    
    // Form fields for Change Request
    public $student_id;
    public $name;
    public $nis;
    public $email;
    public $notes;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function openForm($id)
    {
        $this->resetValidation();
        $student = User::findOrFail($id);
        
        $this->student_id = $student->id;
        $this->name = $student->name;
        $this->nis = $student->nis;
        $this->email = $student->email;
        $this->notes = '';
        
        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->reset(['student_id', 'name', 'nis', 'email', 'notes']);
    }

    public function submitChangeRequest()
    {
        $this->validate();

        // Check if there is already a pending request for this student
        $existingRequest = StudentChangeRequest::where('student_id', $this->student_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            session()->flash('error', 'Siswa ini sudah memiliki pengajuan perubahan yang masih tertunda.');
            return;
        }

        StudentChangeRequest::create([
            'teacher_id' => auth()->id(),
            'student_id' => $this->student_id,
            'requested_data' => [
                'name' => $this->name,
                'nis' => $this->nis,
                'email' => $this->email,
            ],
            'status' => 'pending',
            'notes' => $this->notes,
        ]);

        session()->flash('success', 'Pengajuan perubahan data siswa berhasil dikirim ke Admin Sekolah.');
        $this->closeForm();
    }

    public function exportCsv()
    {
        $students = $this->getStudentsQuery()->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=data_siswa_kelasku.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Siswa', 'NIS', 'Email']);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->name,
                    $student->nis,
                    $student->email
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $students = $this->getStudentsQuery()->get();
        $classRooms = ClassRoom::where('homeroom_teacher_id', auth()->id())->pluck('class_name')->implode(', ');
        
        $pdf = Pdf::loadHTML($this->generatePdfHtml($students, $classRooms));
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'data_siswa_kelasku.pdf');
    }

    private function generatePdfHtml($students, $classRooms)
    {
        $html = '<h2 style="text-align:center;">Daftar Siswa</h2>';
        $html .= '<p><strong>Wali Kelas:</strong> ' . auth()->user()->name . '</p>';
        $html .= '<p><strong>Kelas:</strong> ' . ($classRooms ?: 'Belum ada kelas') . '</p>';
        $html .= '<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">';
        $html .= '<tr style="background-color: #f2f2f2;"><th>No</th><th>Nama Siswa</th><th>NIS</th><th>Email</th></tr>';
        
        foreach ($students as $index => $student) {
            $html .= '<tr>';
            $html .= '<td align="center">' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($student->name) . '</td>';
            $html .= '<td>' . htmlspecialchars($student->nis) . '</td>';
            $html .= '<td>' . htmlspecialchars($student->email) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        return $html;
    }

    public $filterClassId = '';

    public function mount()
    {
        $user = auth()->user();
        $firstClass = ClassRoom::where('homeroom_teacher_id', $user->id)
            ->orWhereHas('teachers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })->first();
            
        if ($firstClass) {
            $this->filterClassId = $firstClass->id;
        }
    }

    private function getAvailableClasses()
    {
        $user = auth()->user();
        return ClassRoom::where('homeroom_teacher_id', $user->id)
            ->orWhereHas('teachers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })->get();
    }

    private function getStudentsQuery()
    {
        $classIds = $this->filterClassId ? [$this->filterClassId] : $this->getAvailableClasses()->pluck('id')->toArray();
        
        return User::where('role', 'siswa')
            ->whereHas('studentClasses', function ($query) use ($classIds) {
                $query->whereIn('class_id', $classIds);
            })
            ->with(['changeRequests' => function ($query) {
                $query->where('status', 'pending');
            }])
            ->orderBy('name');
    }

    public function render()
    {
        $students = $this->getStudentsQuery()->paginate(15);
        $classRooms = $this->getAvailableClasses();
        
        return view('livewire.guru.siswa-manager', compact('students', 'classRooms'));
    }
}
