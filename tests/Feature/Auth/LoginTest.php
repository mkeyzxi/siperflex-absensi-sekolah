<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database
        $this->artisan('db:seed');
    }

    public function test_login_page_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeLivewire(Login::class);
    }

    public function test_user_can_login_with_correct_credentials_and_redirects_based_on_role()
    {
        // 1. Test Siswa Login
        Livewire::test(Login::class)
            ->set('identifier', 'andisiswa')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/siswa/dashboard');
            
        $this->assertAuthenticated();
        auth()->logout();

        // 2. Test Guru Login
        Livewire::test(Login::class)
            ->set('identifier', 'budiguru')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/guru/dashboard');
            
        $this->assertAuthenticated();
        auth()->logout();

        // 3. Test Admin Sekolah Login
        Livewire::test(Login::class)
            ->set('identifier', 'adminsekolah')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/admin/dashboard');
            
        $this->assertAuthenticated();
        auth()->logout();

        // 4. Test Super Admin Login
        Livewire::test(Login::class)
            ->set('identifier', 'superadmin')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/super-admin/dashboard');
    }

    public function test_login_validation_fails_with_empty_fields()
    {
        Livewire::test(Login::class)
            ->set('identifier', '')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors(['identifier', 'password']);
    }

    public function test_login_fails_with_wrong_password()
    {
        Livewire::test(Login::class)
            ->set('identifier', 'andisiswa')
            ->set('password', 'wrongpassword')
            ->call('login')
            ->assertHasErrors('identifier'); // The error is bound to 'identifier'
            
        $this->assertGuest();
    }
}
