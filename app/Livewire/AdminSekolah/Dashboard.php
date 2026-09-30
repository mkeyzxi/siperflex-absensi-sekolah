<?php

namespace App\Livewire\AdminSekolah;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    use WithPagination;

    public $activeTab = 'guru'; // 'guru' or 'siswa'
    public $isFormOpen = false;
    public $isEditing = false;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Form fields
    public $user_id;
    public $name;
    public $email;
    public $identifier; // NIP for Guru, NIS for Siswa
    public $password;

    protected function rules()
    {
        $uniqueRule = $this->activeTab === 'guru'
            ? 'unique:users,nip,' . $this->user_id
            : 'unique:users,nis,' . $this->user_id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user_id,
            'identifier' => 'required|string|max:50|' . $uniqueRule,
            'password' => $this->isEditing ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->closeForm();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->isEditing = false;

        if ($id) {
            $user = User::findOrFail($id);
            $this->user_id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->identifier = $this->activeTab === 'guru' ? $user->nip : $user->nis;
            $this->password = '';
            $this->isEditing = true;
        } else {
            $this->reset(['user_id', 'name', 'email', 'identifier', 'password']);
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->reset(['user_id', 'name', 'email', 'identifier', 'password']);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'school_id' => auth()->user()->school_id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->activeTab,
            'is_active' => true,
        ];

        if ($this->activeTab === 'guru') {
            $data['nip'] = $this->identifier;
        } else {
            $data['nis'] = $this->identifier;
        }

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEditing) {
            User::findOrFail($this->user_id)->update($data);
            session()->flash('success', 'Data berhasil diperbarui.');
        } else {
            User::create($data);
            session()->flash('success', 'Data baru berhasil ditambahkan.');
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('success', 'Data berhasil dihapus.');
    }

    public function render()
    {
        $users = User::where('school_id', auth()->user()->school_id)
            ->where('role', $this->activeTab)
            ->where(function($query) {
                if ($this->search) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%')
                          ->orWhere('nip', 'like', '%' . $this->search . '%')
                          ->orWhere('nis', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.adminsekolah.dashboard', compact('users'));
    }
}
