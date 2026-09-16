<?php

namespace Tests\Feature\Livewire\SuperAdmin;

use App\Livewire\SuperAdmin\Dashboard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_super_admin_dashboard_can_be_rendered()
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        $response = $this->get('/super-admin/dashboard');
        $response->assertStatus(200);
        $response->assertSeeLivewire(Dashboard::class);
    }

    public function test_super_admin_can_add_new_school()
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->actingAs($superAdmin);

        Livewire::test(Dashboard::class)
            ->call('openForm')
            ->set('code', 'SCH002')
            ->set('npsn', '87654321')
            ->set('name', 'SMA Negeri 2 Siperflex')
            ->set('address', 'Jl. Baru No. 2')
            ->set('phone', '08123456789')
            ->set('email', 'sman2@test.com')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Sekolah baru berhasil ditambahkan');

        $this->assertDatabaseHas('schools', [
            'code' => 'SCH002',
            'npsn' => '87654321',
            'name' => 'SMA Negeri 2 Siperflex',
        ]);
    }
}
