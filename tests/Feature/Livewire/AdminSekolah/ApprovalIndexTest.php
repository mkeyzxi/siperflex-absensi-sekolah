<?php

namespace Tests\Feature\Livewire\AdminSekolah;

use App\Livewire\AdminSekolah\Approval\Index;
use App\Models\User;
use App\Models\StudentChangeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ApprovalIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_approval_index_can_be_rendered()
    {
        $adminSekolah = User::where('role', 'admin_sekolah')->first();
        $this->actingAs($adminSekolah);

        $response = $this->get('/admin/persetujuan');
        $response->assertStatus(200);
        $response->assertSeeLivewire(Index::class);
    }

    public function test_admin_sekolah_can_approve_student_change_request()
    {
        $adminSekolah = User::where('role', 'admin_sekolah')->first();
        $siswa = User::where('role', 'siswa')->first();
        $guru = User::where('role', 'guru')->first();
        $this->actingAs($adminSekolah);

        // Create a pending request
        $request = StudentChangeRequest::create([
            'teacher_id' => $guru->id,
            'student_id' => $siswa->id,
            'requested_data' => [
                'name' => 'Nama Baru Andi',
                'nis' => '112233',
                'email' => 'andibaru@test.com',
            ],
            'status' => 'pending',
            'notes' => 'Tolong update'
        ]);

        Livewire::test(Index::class)
            ->call('openApprovalModal', $request->id, 'approve')
            ->call('processRequest')
            ->assertHasNoErrors()
            ->assertSee('disetujui');

        $this->assertDatabaseHas('student_change_requests', [
            'id' => $request->id,
            'status' => 'approved',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $siswa->id,
            'name' => 'Nama Baru Andi',
            'nis' => '112233',
            'email' => 'andibaru@test.com',
        ]);
    }
}
