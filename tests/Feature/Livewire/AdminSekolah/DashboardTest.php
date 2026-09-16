<?php

namespace Tests\Feature\Livewire\AdminSekolah;

use App\Livewire\AdminSekolah\Dashboard;
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

    public function test_admin_sekolah_dashboard_can_be_rendered()
    {
        $adminSekolah = User::where('role', 'admin_sekolah')->first();
        $this->actingAs($adminSekolah);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSeeLivewire(Dashboard::class);
    }
}
