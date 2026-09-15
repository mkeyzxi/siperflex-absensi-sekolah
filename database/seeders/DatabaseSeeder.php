<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create School
        $school = School::create([
            'code' => 'SCH001',
            'npsn' => '12345678',
            'name' => 'SMA Negeri 1 Siperflex',
            'address' => 'Jl. Pendidikan No. 1',
            'phone' => '0211234567',
            'email' => 'info@sman1siperflex.sch.id',
            'is_active' => true,
        ]);

        // 2. Create Academic Year
        $academicYear = AcademicYear::create([
            'school_id' => $school->id,
            'name' => '2026/2027 Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
            'is_active' => true,
        ]);

        // 3. Create Users
        $password = Hash::make('password');

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@siperflex.com',
            'password' => $password,
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $adminSekolah = User::create([
            'school_id' => $school->id,
            'name' => 'Admin Sekolah',
            'username' => 'adminsekolah',
            'email' => 'admin@sman1siperflex.sch.id',
            'nip' => '198001012010011001',
            'password' => $password,
            'role' => 'admin_sekolah',
            'is_active' => true,
        ]);

        $guru = User::create([
            'school_id' => $school->id,
            'name' => 'Budi Guru, S.Pd',
            'username' => 'budiguru',
            'email' => 'budi@sman1siperflex.sch.id',
            'nip' => '198502022012021002',
            'password' => $password,
            'role' => 'guru',
            'is_active' => true,
        ]);

        $siswa = User::create([
            'school_id' => $school->id,
            'name' => 'Andi Siswa',
            'username' => 'andisiswa',
            'email' => 'andi@student.sman1siperflex.sch.id',
            'nis' => '12345',
            'password' => $password,
            'role' => 'siswa',
            'is_active' => true,
        ]);

        // 4. Create ClassRoom
        $classRoom = ClassRoom::create([
            'school_id' => $school->id,
            'academic_year_id' => $academicYear->id,
            'class_name' => 'X MIPA 1',
            'grade_level' => '10',
            'major' => 'MIPA',
            'homeroom_teacher_id' => $guru->id,
            'is_active' => true,
        ]);

        // 5. Assign Teacher and Student to Class
        DB::table('class_teacher')->insert([
            'school_id' => $school->id,
            'class_id' => $classRoom->id,
            'teacher_id' => $guru->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('class_student')->insert([
            'school_id' => $school->id,
            'class_id' => $classRoom->id,
            'student_id' => $siswa->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
