<?php

namespace Tests\Feature\Livewire\Siswa;

use App\Livewire\Siswa\Dashboard;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
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

    public function test_siswa_dashboard_can_be_rendered()
    {
        $siswa = User::where('role', 'siswa')->first();
        $this->actingAs($siswa);

        $response = $this->get('/siswa/dashboard');
        $response->assertStatus(200);
        $response->assertSeeLivewire(Dashboard::class);
    }

    public function test_siswa_can_submit_attendance()
    {
        $siswa = User::where('role', 'siswa')->first();
        $this->actingAs($siswa);

        // Ensure no attendance yet
        $this->assertDatabaseMissing('attendances', [
            'student_id' => $siswa->id,
            'date' => now()->toDateString(),
        ]);

        Livewire::test(Dashboard::class)
            ->set('status', 'hadir')
            ->set('mood', 'senang')
            ->set('reflection_text', 'Hari ini menyenangkan')
            ->set('latitude', '-6.200000')
            ->set('longitude', '106.816666')
            ->call('submitAttendance')
            ->assertHasNoErrors()
            ->assertSee('Absensi berhasil disubmit.');

        $this->assertDatabaseHas('attendances', [
            'student_id' => $siswa->id,
            'status' => 'hadir',
            'mood' => 'senang',
        ]);
    }

    public function test_siswa_cannot_submit_attendance_with_long_reflection()
    {
        $siswa = User::where('role', 'siswa')->first();
        $this->actingAs($siswa);

        $longReflection = "Satu dua tiga empat lima enam tujuh delapan sembilan sepuluh sebelas";

        Livewire::test(Dashboard::class)
            ->set('status', 'hadir')
            ->set('reflection_text', $longReflection)
            ->call('submitAttendance')
            ->assertHasErrors(['reflection_text']);
    }

    public function test_siswa_can_upload_profile_photo()
    {
        Storage::fake('public');
        
        $siswa = User::where('role', 'siswa')->first();
        $this->actingAs($siswa);

        $file = UploadedFile::fake()->image('profile.jpg');

        Livewire::test(Dashboard::class)
            ->set('profilePhoto', $file);

        $siswa->refresh();
        $this->assertNotNull($siswa->profile_photo_path);
        Storage::disk('public')->assertExists($siswa->profile_photo_path);
    }
}
