<?php

namespace Tests\Feature\Livewire\AdminSekolah;

use App\Livewire\AdminSekolah\Kelas\Index;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KelasIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_admin_sekolah_kelas_index_can_be_rendered()
    {
        $adminSekolah = User::where('role', 'admin_sekolah')->first();
        $this->actingAs($adminSekolah);

        $response = $this->get('/admin/kelas');
        $response->assertStatus(200);
        $response->assertSeeLivewire(Index::class);
    }

    public function test_admin_sekolah_can_create_kelas()
    {
        $adminSekolah = User::where('role', 'admin_sekolah')->first();
        $this->actingAs($adminSekolah);

        Livewire::test(Index::class)
            ->call('openForm')
            ->set('class_name', 'XI MIPA 2')
            ->set('grade_level', '11')
            ->set('major', 'MIPA')
            ->set('is_active', true)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('class_rooms', [
            'class_name' => 'XI MIPA 2',
            'school_id' => $adminSekolah->school_id,
        ]);
    }

    public function test_admin_sekolah_can_update_kelas()
    {
        $adminSekolah = User::where('role', 'admin_sekolah')->first();
        $this->actingAs($adminSekolah);
        
        $class = ClassRoom::where('school_id', $adminSekolah->school_id)->first();

        Livewire::test(Index::class)
            ->call('openForm', $class->id)
            ->set('class_name', 'XI MIPA 2 UPDATE')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('class_rooms', [
            'id' => $class->id,
            'class_name' => 'XI MIPA 2 UPDATE',
        ]);
    }
}
