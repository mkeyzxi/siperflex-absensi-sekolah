<?php

namespace App\Livewire\SuperAdmin;

use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    use WithPagination;

    public $isFormOpen = false;
    public $isEditing = false;
    public $search = '';

    // Admin view properties
    public $isAdminModalOpen = false;
    public $selectedSchoolAdmins = [];
    public $selectedSchoolName = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Form fields
    public $school_id;
    public $name;
    public $code;
    public $npsn;
    public $address;
    public $phone;
    public $email;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:schools,code',
        'npsn' => 'nullable|string|max:50',
        'address' => 'required|string',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'is_active' => 'boolean',
    ];

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->isEditing = false;

        if ($id) {
            $school = School::findOrFail($id);
            $this->school_id = $school->id;
            $this->name = $school->name;
            $this->code = $school->code;
            $this->npsn = $school->npsn;
            $this->address = $school->address;
            $this->phone = $school->phone;
            $this->email = $school->email;
            $this->is_active = $school->is_active;

            // Adjust validation rules for update
            $this->rules['code'] = 'required|string|max:50|unique:schools,code,' . $this->school_id;
            $this->isEditing = true;
        } else {
            $this->reset(['school_id', 'name', 'code', 'npsn', 'address', 'phone', 'email', 'is_active']);
            $this->is_active = true;
            $this->rules['code'] = 'required|string|max:50|unique:schools,code';
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->reset(['school_id', 'name', 'code', 'npsn', 'address', 'phone', 'email', 'is_active']);
    }

    public function save()
    {
        // Adjust rule if editing
        if ($this->isEditing) {
            $this->rules['code'] = 'required|string|max:50|unique:schools,code,' . $this->school_id;
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'npsn' => $this->npsn,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            School::findOrFail($this->school_id)->update($data);
            session()->flash('success', 'Sekolah berhasil diperbarui.');
        } else {
            $school = School::create($data);

            // Create Admin Sekolah account automatically
            // Using a unique email based on school code if not using actual email
            $adminEmail = 'admin.' . strtolower($school->code) . '@siperflex.test';

            User::create([
                'school_id' => $school->id,
                'name' => 'Admin ' . $school->name,
                'email' => $adminEmail,
                'password' => Hash::make('password'),
                'role' => 'admin_sekolah',
                'is_active' => true,
            ]);

            session()->flash('success', 'Sekolah baru dan akun Admin berhasil ditambahkan. (Email: ' . $adminEmail . ' | Pass: password)');
        }

        $this->closeForm();
    }

    public function showAdmins($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $this->selectedSchoolName = $school->name;

        $this->selectedSchoolAdmins = User::where('school_id', $schoolId)
            ->where('role', 'admin_sekolah')
            ->get();

        $this->isAdminModalOpen = true;
    }

    public function deleteSchool($schoolId)
    {
        $school = School::findOrFail($schoolId);

        User::where('school_id', $school->id)->delete();
        $school->delete();

        session()->flash('success', 'Sekolah dan akun terkait berhasil dihapus.');
    }

    public function closeAdminModal()
    {
        $this->isAdminModalOpen = false;
        $this->selectedSchoolAdmins = [];
        $this->selectedSchoolName = '';
    }

    public function render()
    {
        $schools = School::where(function($query) {
            if ($this->search) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('npsn', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%');
            }
        })->orderBy('name')->paginate(10);

        return view('livewire.superadmin.dashboard', compact('schools'));
    }
}
