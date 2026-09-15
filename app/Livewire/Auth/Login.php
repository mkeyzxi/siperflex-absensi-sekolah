<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public $identifier = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $this->identifier)
            ->orWhere('username', $this->identifier)
            ->orWhere('nis', $this->identifier)
            ->orWhere('nip', $this->identifier)
            ->first();

        if ($user && Hash::check($this->password, $user->password)) {
            if (!$user->is_active) {
                $this->addError('identifier', 'Akun Anda dinonaktifkan.');
                return;
            }

            Auth::login($user);
            session()->regenerate();
            
            return $this->redirectBasedOnRole($user);
        }

        $this->addError('identifier', 'Identitas atau kata sandi salah.');
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'super_admin') {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->role === 'admin_sekolah') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
        
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.app');
    }
}
