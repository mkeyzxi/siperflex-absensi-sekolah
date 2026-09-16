<?php

namespace Tests\Feature\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_guest_cannot_access_protected_routes()
    {
        $this->get('/siswa/dashboard')->assertRedirect('/login');
        $this->get('/guru/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/super-admin/dashboard')->assertRedirect('/login');
    }

    public function test_siswa_cannot_access_other_roles_routes()
    {
        $siswa = User::where('role', 'siswa')->first();
        $this->actingAs($siswa);

        $this->get('/siswa/dashboard')->assertStatus(200);
        $this->get('/guru/dashboard')->assertStatus(403);
        $this->get('/admin/dashboard')->assertStatus(403);
        $this->get('/super-admin/dashboard')->assertStatus(403);
    }

    public function test_guru_cannot_access_other_roles_routes()
    {
        $guru = User::where('role', 'guru')->first();
        $this->actingAs($guru);

        $this->get('/guru/dashboard')->assertStatus(200);
        $this->get('/siswa/dashboard')->assertStatus(403);
        $this->get('/admin/dashboard')->assertStatus(403);
        $this->get('/super-admin/dashboard')->assertStatus(403);
    }

    public function test_admin_sekolah_cannot_access_other_roles_routes()
    {
        $adminSekolah = User::where('role', 'admin_sekolah')->first();
        $this->actingAs($adminSekolah);

        $this->get('/admin/dashboard')->assertStatus(200);
        $this->get('/siswa/dashboard')->assertStatus(403);
        $this->get('/guru/dashboard')->assertStatus(403);
        $this->get('/super-admin/dashboard')->assertStatus(403);
    }

    public function test_super_admin_cannot_access_other_roles_routes()
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $this->get('/super-admin/dashboard')->assertStatus(200);
        $this->get('/siswa/dashboard')->assertStatus(403);
        $this->get('/guru/dashboard')->assertStatus(403);
        $this->get('/admin/dashboard')->assertStatus(403);
    }
}
