<?php

namespace App\Livewire\Siswa;

use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
  use WithFileUploads;

  /** @var string */
  public $status = 'hadir';
  /** @var string */
  public $mood = '';
  /** @var string */
  public $reflection_text = '';
  /** @var float|string|null */
  public $latitude;
  /** @var float|string|null */
  public $longitude;
  /** @var \App\Models\Attendance|null */
  public $attendanceToday = null;
  /** @var \Illuminate\Database\Eloquent\Collection|array */
  public $attendanceHistory = [];
  /** @var string|null */
  public $photo = null;

  /** @var mixed */
  public $profilePhoto;

  public function mount()
  {
    $this->checkAttendance();
  }

  public function updatedProfilePhoto()
  {
    $this->validate([
      'profilePhoto' => 'image|max:2048', // 2MB Max
    ], [
      'profilePhoto.image' => 'File harus berupa gambar (JPG, PNG).',
      'profilePhoto.max' => 'Ukuran gambar maksimal adalah 2MB.',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    $path = $this->profilePhoto->store('profiles', 'public');

    $user->update([
      'profile_photo_path' => $path
    ]);

    // Refresh the cached auth user so the view updates immediately
    Auth::setUser($user->fresh());

    session()->flash('profile_success', 'Foto profil berhasil diperbarui.');
  }

  public function checkAttendance()
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $this->attendanceToday = Attendance::where('student_id', $user->id)
      ->whereDate('date', Carbon::today())
      ->first();

    // Ambil riwayat absensi (maksimal 30 hari terakhir)
    $this->attendanceHistory = Attendance::where('student_id', $user->id)
      ->whereDate('date', '!=', Carbon::today())
      ->orderBy('date', 'desc')
      ->take(30)
      ->get();
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
      'photo' => 'required|string',
    ], [
      'photo.required' => 'Foto kehadiran wajib diambil sebagai bukti.',
      'reflection_text.required' => 'Teks refleksi wajib diisi.',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Find student class
    $classStudent = DB::table('class_student')->where('student_id', $user->id)->first();

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
