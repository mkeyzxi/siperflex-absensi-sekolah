<?php

namespace Tests\Unit\Models;

use App\Models\Attendance;
use App\Models\User;
use App\Models\ClassRoom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_attendance_belongs_to_student()
    {
        $siswa = User::where('role', 'siswa')->first();
        $classRoom = ClassRoom::first();
        
        $attendance = Attendance::create([
            'school_id' => $siswa->school_id,
            'student_id' => $siswa->id,
            'class_id' => $classRoom->id,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'status' => 'hadir',
        ]);

        $this->assertInstanceOf(User::class, $attendance->student);
        $this->assertEquals($siswa->id, $attendance->student->id);
    }
}
