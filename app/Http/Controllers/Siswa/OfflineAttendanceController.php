<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OfflineAttendanceController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.status' => 'required|in:hadir,terlambat,sakit,izin',
            'attendances.*.mood' => 'nullable|string|max:255',
            'attendances.*.reflection_text' => 'required|string',
            'attendances.*.photo' => 'required|string',
            'attendances.*.latitude' => 'nullable|numeric',
            'attendances.*.longitude' => 'nullable|numeric',
            'attendances.*.offline_created_at' => 'required|date', // Time when offline attendance was created
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $classStudent = DB::table('class_student')->where('student_id', $user->id)->first();
        if (!$classStudent) {
            return response()->json(['error' => 'No class assigned to student'], 400);
        }

        $syncedCount = 0;
        
        foreach ($request->attendances as $offlineData) {
            $offlineDate = Carbon::parse($offlineData['offline_created_at']);
            
            // Check if attendance already exists for that specific date to prevent duplicates
            $existing = Attendance::where('student_id', $user->id)
                ->whereDate('date', $offlineDate->toDateString())
                ->first();

            if ($existing) {
                continue; // Skip if already synced
            }

            $photoPath = null;
            if (!empty($offlineData['photo'])) {
                // Decode base64 and save to storage
                $imageParts = explode(";base64,", $offlineData['photo']);
                if (count($imageParts) == 2) {
                    $imageTypeAux = explode("image/", $imageParts[0]);
                    $imageType = $imageTypeAux[1] ?? 'jpeg';
                    $imageBase64 = base64_decode($imageParts[1]);
                    $fileName = 'attendance/' . $user->id . '_offline_' . time() . '_' . rand(100,999) . '.' . $imageType;

                    Storage::disk('public')->put($fileName, $imageBase64);
                    $photoPath = $fileName;
                }
            }

            Attendance::create([
                'school_id' => $user->school_id,
                'student_id' => $user->id,
                'class_id' => $classStudent->class_id,
                'date' => $offlineDate->toDateString(),
                'time' => $offlineDate->toTimeString(),
                'status' => $offlineData['status'],
                'mood' => $offlineData['mood'],
                'reflection_text' => $offlineData['reflection_text'],
                'latitude' => $offlineData['latitude'] ?? null,
                'longitude' => $offlineData['longitude'] ?? null,
                'photo_path' => $photoPath,
            ]);

            $syncedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "$syncedCount attendances synced successfully."
        ]);
    }
}
