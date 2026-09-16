<?php

namespace Tests\Feature\Livewire\Guru;

use App\Livewire\Guru\Dashboard;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Attendance;
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

    public function test_guru_dashboard_can_be_rendered()
    {
        $guru = User::where('role', 'guru')->first();
        $this->actingAs($guru);

        $response = $this->get('/guru/dashboard');
        $response->assertStatus(200);
        $response->assertSeeLivewire(Dashboard::class);
    }

    public function test_guru_can_filter_students()
    {
        $guru = User::where('role', 'guru')->first();
        $this->actingAs($guru);

        $class = ClassRoom::where('homeroom_teacher_id', $guru->id)->first();
        $this->assertNotNull($class);

        Livewire::test(Dashboard::class)
            ->set('filterClassId', $class->id)
            ->set('search', 'Andi')
            ->assertSee('Andi Siswa');
    }

    public function test_guru_can_download_csv()
    {
        $guru = User::where('role', 'guru')->first();
        $this->actingAs($guru);

        $class = ClassRoom::where('homeroom_teacher_id', $guru->id)->first();

        $response = Livewire::test(Dashboard::class)
            ->set('filterClassId', $class->id)
            ->call('exportCsv');
            
        $response->assertFileDownloaded('kehadiran_siswa_' . now()->format('Y-m-d') . '.csv');
    }
}
