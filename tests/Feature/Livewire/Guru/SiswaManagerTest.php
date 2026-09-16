<?php

namespace Tests\Feature\Livewire\Guru;

use App\Livewire\Guru\SiswaManager;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\StudentChangeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SiswaManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_siswa_manager_can_be_rendered()
    {
        $guru = User::where('role', 'guru')->first();
        $this->actingAs($guru);

        $response = $this->get('/guru/siswa');
        $response->assertStatus(200);
        $response->assertSeeLivewire(SiswaManager::class);
    }

    public function test_guru_can_search_students()
    {
        $guru = User::where('role', 'guru')->first();
        $this->actingAs($guru);

        $class = ClassRoom::where('homeroom_teacher_id', $guru->id)->first();

        Livewire::test(SiswaManager::class)
            ->set('filterClassId', $class->id)
            ->set('search', 'Andi Siswa')
            ->assertSee('Andi Siswa');
    }

    public function test_guru_can_submit_student_change_request()
    {
        $guru = User::where('role', 'guru')->first();
        $siswa = User::where('role', 'siswa')->first();
        $this->actingAs($guru);

        Livewire::test(SiswaManager::class)
            ->call('openForm', $siswa->id)
            ->set('name', 'Andi Baru')
            ->set('nis', '54321')
            ->set('email', 'andibaru@test.com')
            ->set('notes', 'Perubahan nama dan NIS')
            ->call('submitChangeRequest')
            ->assertHasNoErrors()
            ->assertSee('Pengajuan perubahan data siswa berhasil dikirim');

        $this->assertDatabaseHas('student_change_requests', [
            'student_id' => $siswa->id,
            'teacher_id' => $guru->id,
            'status' => 'pending',
            'notes' => 'Perubahan nama dan NIS',
        ]);
    }
}
