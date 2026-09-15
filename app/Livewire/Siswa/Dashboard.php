<?php

namespace App\Livewire\Siswa;

use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    use WithFileUploads;

    public $status = 'hadir';
    public $mood = '';
    public $reflection_text = '';
    public $latitude;
    public $longitude;
    public $attendanceToday = null;
    public $photo = null;
    
    public $profilePhoto;

    public function mount()
    {
        $this->checkAttendance();
    }

    public function updatedProfilePhoto()
    {
        $this->validate([
            'profilePhoto' => 'image|max:2048', // 2MB Max
        ]);

        $user = auth()->user();
        $path = $this->profilePhoto->store('profiles', 'public');
        
        $user->update([
            'profile_photo_path' => $path
        ]);

        session()->flash('profile_success', 'Foto profil berhasil diperbarui.');
    }

    public function checkAttendance()
    {
        $user = auth()->user();
        $this->attendanceToday = Attendance::where('student_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();
    }

    public function submitAttendance()
    {
        $this->validate([
            'status' => 'required|in:hadir,terlambat,sakit,izin',
            'mood' => 'nullable|string|max:255',
            'reflection_text' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 10) {
                        $fail('Refleksi maksimal 10 kata.');
                    }
                },
            ],
            'photo' => 'nullable|string',
        ]);

        $user = auth()->user();
        
        // Find student class
        $classStudent = \DB::table('class_student')->where('student_id', $user->id)->first();
        
        if (!$classStudent) {
            session()->flash('error', 'Anda belum tergabung di kelas mana pun.');
            return;
        }

        $photoPath = null;
        if ($this->photo) {
            // Decode base64 and save to storage
            $imageParts = explode(";base64,", $this->photo);
            if (count($imageParts) == 2) {
                $imageTypeAux = explode("image/", $imageParts[0]);
                $imageType = $imageTypeAux[1] ?? 'png';
                $imageBase64 = base64_decode($imageParts[1]);
                $fileName = 'attendance/' . $user->id . '_' . time() . '.' . $imageType;
                
                Storage::disk('public')->put($fileName, $imageBase64);
                $photoPath = $fileName;
            }
        }

        Attendance::create([
            'school_id' => $user->school_id,
            'student_id' => $user->id,
            'class_id' => $classStudent->class_id,
            'date' => Carbon::today(),
            'time' => Carbon::now()->format('H:i:s'),
            'status' => $this->status,
            'mood' => $this->mood,
            'reflection_text' => $this->reflection_text,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'photo_path' => $photoPath,
        ]);

        session()->flash('success', 'Absensi berhasil disubmit.');
        $this->checkAttendance();
    }

    public function render()
    {
        return view('livewire.siswa.dashboard');
    }
}
