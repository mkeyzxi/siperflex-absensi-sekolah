<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password'); // Default password for everyone

        $attendanceStatuses = ['hadir', 'izin', 'sakit', 'terlambat'];
        $moods = ['😁 Senang', '🙂 Biasa', '😔 Sedih', '😴 Ngantuk', '🤔 Bingung'];

        for ($i = 1; $i <= 3; $i++) {
            // 1. Create School
            $school = School::create([
                'code' => 'DUMMY-00' . $i,
                'npsn' => $faker->unique()->numerify('########'),
                'name' => 'SMA Dummy ' . $i . ' Siperflex',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => 'info.sma' . $i . '@siperflex.test',
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

            // 3. Create Teachers (5 per school)
            $teachers = [];
            for ($t = 1; $t <= 5; $t++) {
                $teachers[] = User::create([
                    'school_id' => $school->id,
                    'name' => $faker->name . ', S.Pd.',
                    'username' => 'guru' . $t . '_sma' . $i,
                    'email' => 'guru' . $t . '.sma' . $i . '@siperflex.test',
                    'nip' => $faker->unique()->numerify('##################'),
                    'password' => $password,
                    'role' => 'guru',
                    'is_active' => true,
                ]);
            }

            // 4. Create Classes (2 classes per school)
            $classRooms = [];
            $classRooms[] = ClassRoom::create([
                'school_id' => $school->id,
                'academic_year_id' => $academicYear->id,
                'class_name' => 'X MIPA 1',
                'grade_level' => '10',
                'major' => 'MIPA',
                'homeroom_teacher_id' => $teachers[0]->id,
                'is_active' => true,
            ]);

            $classRooms[] = ClassRoom::create([
                'school_id' => $school->id,
                'academic_year_id' => $academicYear->id,
                'class_name' => 'X IPS 1',
                'grade_level' => '10',
                'major' => 'IPS',
                'homeroom_teacher_id' => $teachers[1]->id,
                'is_active' => true,
            ]);

            // Assign all teachers to all classes in this school for simplicity
            foreach ($classRooms as $class) {
                foreach ($teachers as $teacher) {
                    DB::table('class_teacher')->insert([
                        'school_id' => $school->id,
                        'class_id' => $class->id,
                        'teacher_id' => $teacher->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 5. Create Students (50 per school) and prepare for Attendance
            $students = [];
            for ($s = 1; $s <= 50; $s++) {
                $students[] = User::create([
                    'school_id' => $school->id,
                    'name' => $faker->name,
                    'username' => 'siswa' . $s . '_sma' . $i,
                    'email' => 'siswa' . $s . '.sma' . $i . '@siperflex.test',
                    'nis' => $faker->unique()->numerify('#####'),
                    'password' => $password,
                    'role' => 'siswa',
                    'is_active' => true,
                ]);

                // Assign to class (half in MIPA, half in IPS)
                $classAssigned = ($s <= 25) ? $classRooms[0] : $classRooms[1];
                DB::table('class_student')->insert([
                    'school_id' => $school->id,
                    'class_id' => $classAssigned->id,
                    'student_id' => $students[$s-1]->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 6. Generate Attendances for today
            // Pick 2 students randomly to have NO attendance (belum absen)
            $noAttendanceIndexes = array_rand($students, 2);
            $today = Carbon::today();

            foreach ($students as $index => $student) {
                if (in_array($index, $noAttendanceIndexes)) {
                    continue; // Skip these 2 students
                }

                $status = $faker->randomElement($attendanceStatuses);
                $classAssignedId = ($index < 25) ? $classRooms[0]->id : $classRooms[1]->id;

                // Photo logic
                // using a dummy placeholder URL
                $photoUrl = ($status == 'hadir') 
                    ? 'https://via.placeholder.com/400x400.png?text=Bukti+Hadir+' . urlencode($student->name)
                    : null;
                
                // Only provide latitude, longitude, mood if present (mostly for 'hadir')
                $lat = null;
                $lng = null;
                $mood = null;
                $reflection = null;
                $locValid = false;

                if ($status == 'hadir') {
                    $lat = $school->latitude ? (float) $school->latitude + $faker->randomFloat(6, -0.001, 0.001) : -6.200000;
                    $lng = $school->longitude ? (float) $school->longitude + $faker->randomFloat(6, -0.001, 0.001) : 106.816666;
                    $locValid = true;
                    $mood = $faker->randomElement($moods);
                    $reflection = $faker->sentence;
                }

                Attendance::create([
                    'school_id' => $school->id,
                    'student_id' => $student->id,
                    'class_id' => $classAssignedId,
                    'date' => $today,
                    'time' => $faker->time('H:i:s', '08:00:00'),
                    'status' => $status,
                    'photo_path' => $photoUrl,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'location_accuracy' => $status == 'hadir' ? $faker->numberBetween(5, 50) : null,
                    'location_valid' => $locValid,
                    'mood' => $mood,
                    'reflection_text' => $reflection,
                ]);
            }
        }
    }
}
