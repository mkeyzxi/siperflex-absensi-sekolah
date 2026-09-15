<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
});

Route::middleware(['auth', 'active.user'])->group(function () {
    // Super Admin Routes
    Route::middleware('role:super_admin')->prefix('super-admin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', \App\Livewire\SuperAdmin\Dashboard::class)->name('dashboard');
    });

    // Admin Sekolah Routes
    Route::middleware('role:admin_sekolah')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', \App\Livewire\AdminSekolah\Dashboard::class)->name('dashboard');
        Route::get('/kelas', \App\Livewire\AdminSekolah\Kelas\Index::class)->name('kelas.index');
        Route::get('/kelas/{id}', \App\Livewire\AdminSekolah\Kelas\Show::class)->name('kelas.show');
        Route::get('/persetujuan', \App\Livewire\AdminSekolah\Approval\Index::class)->name('approval.index');
    });

    // Guru Routes
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Guru\Dashboard::class)->name('dashboard');
        Route::get('/siswa', \App\Livewire\Guru\SiswaManager::class)->name('siswa.index');
    });

    // Siswa Routes
    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Siswa\Dashboard::class)->name('dashboard');
    });

    Route::post('/logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        $cookieName = config('session.cookie');
        
        return redirect('/login')
            ->withoutCookie($cookieName)
            ->withoutCookie('XSRF-TOKEN');
    })->name('logout');
});
