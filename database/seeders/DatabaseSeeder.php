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
        $this->call([
            AbsensiDataSeeder::class,
        ]);
    }
}
