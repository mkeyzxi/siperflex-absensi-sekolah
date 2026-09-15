<?php

namespace App\Livewire\AdminSekolah\Kelas;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Response;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $importFile;

    public $isFormOpen = false;
    public $isEditing = false;

    // Form fields
    public $class_id;
    public $class_name;
    public $grade_level;
    public $major;
    public $homeroom_teacher_id;
    public $is_active = true;

    protected function rules()
    {
        return [
            'class_name' => 'required|string|max:255',
            'grade_level' => 'required|string|max:50',
            'major' => 'nullable|string|max:100',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ];
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->isEditing = false;
        
        if ($id) {
            $class = ClassRoom::findOrFail($id);
            $this->class_id = $class->id;
            $this->class_name = $class->class_name;
            $this->grade_level = $class->grade_level;
            $this->major = $class->major;
            $this->homeroom_teacher_id = $class->homeroom_teacher_id;
            $this->is_active = $class->is_active;
            $this->isEditing = true;
        } else {
            $this->reset(['class_id', 'class_name', 'grade_level', 'major', 'homeroom_teacher_id']);
            $this->is_active = true;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->reset(['class_id', 'class_name', 'grade_level', 'major', 'homeroom_teacher_id', 'is_active']);
    }

    public function save()
    {
        $this->validate();

        $school_id = auth()->user()->school_id;
        $academicYear = AcademicYear::where('school_id', $school_id)->where('is_active', true)->first();

        if (!$academicYear) {
            session()->flash('error', 'Tidak ada Tahun Ajaran aktif. Silakan tambahkan tahun ajaran terlebih dahulu.');
            return;
        }

        $data = [
            'school_id' => $school_id,
            'academic_year_id' => $academicYear->id,
            'class_name' => $this->class_name,
            'grade_level' => $this->grade_level,
            'major' => $this->major,
            'homeroom_teacher_id' => $this->homeroom_teacher_id ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            ClassRoom::findOrFail($this->class_id)->update($data);
            session()->flash('success', 'Data kelas berhasil diperbarui.');
        } else {
            ClassRoom::create($data);
            session()->flash('success', 'Kelas baru berhasil ditambahkan.');
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        ClassRoom::findOrFail($id)->delete();
        session()->flash('success', 'Kelas berhasil dihapus.');
    }

    public function exportCsv()
    {
        $school_id = auth()->user()->school_id;
        $classes = ClassRoom::with('homeroomTeacher')->where('school_id', $school_id)->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=data_kelas.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($classes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Kelas', 'Tingkat', 'Jurusan', 'NIP Wali Kelas']);

            foreach ($classes as $class) {
                fputcsv($file, [
                    $class->class_name,
                    $class->grade_level,
                    $class->major,
                    $class->homeroomTeacher ? $class->homeroomTeacher->nip : ''
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function importCsv()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $school_id = auth()->user()->school_id;
        $academicYear = AcademicYear::where('school_id', $school_id)->where('is_active', true)->first();

        if (!$academicYear) {
            session()->flash('error', 'Tidak ada Tahun Ajaran aktif.');
            return;
        }

        $path = $this->importFile->getRealPath();
        $file = fopen($path, 'r');
        
        $header = fgetcsv($file); // skip header
        
        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
            // Format: Nama Kelas, Tingkat, Jurusan, NIP Wali Kelas
            if (count($row) < 2) continue; // minimal nama kelas dan tingkat
            
            $className = trim($row[0]);
            $grade = trim($row[1]);
            $major = isset($row[2]) ? trim($row[2]) : null;
            $teacherNip = isset($row[3]) ? trim($row[3]) : null;
            
            $teacherId = null;
            if ($teacherNip) {
                $teacher = User::where('school_id', $school_id)->where('nip', $teacherNip)->first();
                if ($teacher) $teacherId = $teacher->id;
            }

            ClassRoom::updateOrCreate(
                ['school_id' => $school_id, 'class_name' => $className],
                [
                    'academic_year_id' => $academicYear->id,
                    'grade_level' => $grade,
                    'major' => $major,
                    'homeroom_teacher_id' => $teacherId,
                    'is_active' => true
                ]
            );
            $count++;
        }
        
        fclose($file);
        $this->reset('importFile');
        session()->flash('success', "$count kelas berhasil diimpor.");
    }

    public function render()
    {
        $school_id = auth()->user()->school_id;
        
        $classes = ClassRoom::with(['homeroomTeacher', 'academicYear'])
            ->withCount(['students'])
            ->where('school_id', $school_id)
            ->orderBy('grade_level')
            ->orderBy('class_name')
            ->paginate(10);
            
        $teachers = User::where('school_id', $school_id)
            ->where('role', 'guru')
            ->orderBy('name')
            ->get();
            
        return view('livewire.adminsekolah.kelas.index', compact('classes', 'teachers'));
    }
}
