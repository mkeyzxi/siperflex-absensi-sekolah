<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_user_belongs_to_school()
    {
        $siswa = User::where('role', 'siswa')->first();
        
        $this->assertInstanceOf(School::class, $siswa->school);
    }

    public function test_user_has_correct_role()
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->assertEquals('super_admin', $superAdmin->role);

        $guru = User::where('role', 'guru')->first();
        $this->assertEquals('guru', $guru->role);
    }
}
