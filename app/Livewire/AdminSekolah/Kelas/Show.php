<?php

namespace App\Livewire\AdminSekolah\Kelas;

use App\Models\ClassRoom;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.admin')]
class Show extends Component
{
    public $class_id;
    public $classRoom;
    public $activeTab = 'siswa'; // 'siswa' or 'guru'
    
    // For adding students
    public $availableStudents = [];
    public $selectedStudents = [];
    public $searchStudent = '';
    public $showAddStudentModal = false;

    // For adding teachers
    public $availableTeachers = [];
    public $selectedTeachers = [];
    public $searchTeacher = '';
    public $showAddTeacherModal = false;

    public function mount($id)
    {
        $this->class_id = $id;
        $this->classRoom = ClassRoom::with(['school', 'academicYear', 'homeroomTeacher'])->findOrFail($id);
        
        // Ensure user belongs to the same school
        if ($this->classRoom->school_id !== auth()->user()->school_id) {
            abort(403, 'Unauthorized access to this class.');
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // --- STUDENT MANAGEMENT ---
    
    public function openAddStudentModal()
    {
        $this->searchStudent = '';
        $this->selectedStudents = [];
        $this->loadAvailableStudents();
        $this->showAddStudentModal = true;
    }

    public function closeAddStudentModal()
    {
        $this->showAddStudentModal = false;
    }

    public function updatedSearchStudent()
    {
        $this->loadAvailableStudents();
    }

    public function loadAvailableStudents()
    {
        // Get students in this school not already in THIS class
        $existingStudentIds = $this->classRoom->students()->pluck('users.id')->toArray();
        
        $query = User::where('school_id', $this->classRoom->school_id)
            ->where('role', 'siswa')
            ->whereNotIn('id', $existingStudentIds)
            ->orderBy('name');
            
        if (!empty($this->searchStudent)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchStudent . '%')
                  ->orWhere('nis', 'like', '%' . $this->searchStudent . '%');
            });
        }
        
        $this->availableStudents = $query->take(50)->get();
    }

    public function addSelectedStudents()
    {
        if (!empty($this->selectedStudents)) {
            $pivotData = array_fill_keys($this->selectedStudents, ['school_id' => $this->classRoom->school_id]);
            $this->classRoom->students()->attach($pivotData);
            session()->flash('success', count($this->selectedStudents) . ' Siswa berhasil ditambahkan ke kelas.');
            $this->closeAddStudentModal();
        }
    }

    public function removeStudent($studentId)
    {
        $this->classRoom->students()->detach($studentId);
        session()->flash('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }

    // --- TEACHER MANAGEMENT ---

    public function openAddTeacherModal()
    {
        $this->searchTeacher = '';
        $this->selectedTeachers = [];
        $this->loadAvailableTeachers();
        $this->showAddTeacherModal = true;
    }

    public function closeAddTeacherModal()
    {
        $this->showAddTeacherModal = false;
    }

    public function updatedSearchTeacher()
    {
        $this->loadAvailableTeachers();
    }

    public function loadAvailableTeachers()
    {
        // Get teachers in this school not already teaching THIS class
        $existingTeacherIds = $this->classRoom->teachers()->pluck('users.id')->toArray();
        
        $query = User::where('school_id', $this->classRoom->school_id)
            ->where('role', 'guru')
            ->whereNotIn('id', $existingTeacherIds)
            ->orderBy('name');
            
        if (!empty($this->searchTeacher)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTeacher . '%')
                  ->orWhere('nip', 'like', '%' . $this->searchTeacher . '%');
            });
        }
        
        $this->availableTeachers = $query->take(50)->get();
    }

    public function addSelectedTeachers()
    {
        if (!empty($this->selectedTeachers)) {
            $pivotData = array_fill_keys($this->selectedTeachers, ['school_id' => $this->classRoom->school_id]);
            $this->classRoom->teachers()->attach($pivotData);
            session()->flash('success', count($this->selectedTeachers) . ' Guru berhasil ditugaskan ke kelas.');
            $this->closeAddTeacherModal();
        }
    }

    public function removeTeacher($teacherId)
    {
        $this->classRoom->teachers()->detach($teacherId);
        session()->flash('success', 'Guru berhasil dihapus dari penugasan kelas ini.');
    }

    public function render()
    {
        // Refresh classroom data
        $this->classRoom->load(['students' => function($q) {
            $q->orderBy('name');
        }, 'teachers' => function($q) {
            $q->orderBy('name');
        }]);
        
        return view('livewire.adminsekolah.kelas.show');
    }
}
