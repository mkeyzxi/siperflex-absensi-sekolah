<?php

namespace App\Livewire\Guru;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public $filterDate;
    public $filterStatus = '';
    public $filterClassId = '';
    public $search = '';

    public function updatingSearch()
    {
        // For simple get() queries without pagination, updating this simply triggers re-render
    }

    public function mount()
    {
        $this->filterDate = Carbon::today()->format('Y-m-d');
        
        $user = auth()->user();
        $firstClass = ClassRoom::where('homeroom_teacher_id', $user->id)
            ->orWhereHas('teachers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })->first();
            
        if ($firstClass) {
            $this->filterClassId = $firstClass->id;
        }
    }

    private function getAttendanceData()
    {
        $user = auth()->user();
        
        $availableClasses = ClassRoom::where('homeroom_teacher_id', $user->id)
            ->orWhereHas('teachers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })->get();

        $classRoom = null;
        $students = collect();
        $attendances = collect();
        
        if ($this->filterClassId) {
            $classRoom = $availableClasses->firstWhere('id', $this->filterClassId);
            
            if ($classRoom) {
                $studentIds = \DB::table('class_student')
                    ->where('class_id', $classRoom->id)
                    ->pluck('student_id');

                $studentsQuery = User::whereIn('id', $studentIds);
                if ($this->search) {
                    $studentsQuery->where(function($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('nis', 'like', '%' . $this->search . '%');
                    });
                }
                $students = $studentsQuery->orderBy('name')->get();

                $attendancesList = Attendance::whereIn('student_id', $studentIds)
                    ->whereDate('date', $this->filterDate)
                    ->get();
                    
                $attendances = $attendancesList->keyBy('student_id');
                
                if ($this->filterStatus !== '') {
                    if ($this->filterStatus === 'belum_absen') {
                        $students = $students->filter(function($student) use ($attendances) {
                            return !$attendances->has($student->id);
                        });
                    } else {
                        $students = $students->filter(function($student) use ($attendances) {
                            return $attendances->has($student->id) && $attendances->get($student->id)->status === $this->filterStatus;
                        });
                    }
                }
            }
        }
        
        return compact('availableClasses', 'classRoom', 'students', 'attendances');
    }

    public function exportCsv()
    {
        $data = $this->getAttendanceData();
        $students = $data['students'];
        $attendances = $data['attendances'];

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=kehadiran_siswa_" . $this->filterDate . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($students, $attendances) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Siswa', 'NIS', 'Status', 'Waktu', 'Lokasi', 'Catatan']);

            foreach ($students as $student) {
                $att = $attendances->get($student->id);
                $status = $att ? ucfirst($att->status) : 'Belum Absen';
                $waktu = $att ? \Carbon\Carbon::parse($att->time)->format('H:i') : '-';
                $lokasi = ($att && $att->latitude && $att->longitude) ? $att->latitude . ', ' . $att->longitude : '-';
                $catatan = $att ? $att->reflection_text : '-';

                fputcsv($file, [
                    $student->name,
                    $student->nis,
                    $status,
                    $waktu,
                    $lokasi,
                    $catatan
                ]);
            }
            fclose($file);
        };

        return \Illuminate\Support\Facades\Response::stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $data = $this->getAttendanceData();
        $students = $data['students'];
        $attendances = $data['attendances'];
        $classRoom = $data['classRoom'];

        $html = '<h2 style="text-align:center;">Laporan Kehadiran Siswa</h2>';
        $html .= '<p><strong>Kelas:</strong> ' . ($classRoom ? htmlspecialchars($classRoom->class_name) : '-') . '</p>';
        $html .= '<p><strong>Tanggal:</strong> ' . \Carbon\Carbon::parse($this->filterDate)->translatedFormat('d F Y') . '</p>';
        $html .= '<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; font-size: 12px;">';
        $html .= '<tr style="background-color: #f2f2f2;"><th>No</th><th>Nama Siswa</th><th>NIS</th><th>Status</th><th>Waktu</th></tr>';
        
        $no = 1;
        foreach ($students as $student) {
            $att = $attendances->get($student->id);
            $status = $att ? ucfirst($att->status) : 'Belum Absen';
            $waktu = $att ? \Carbon\Carbon::parse($att->time)->format('H:i') : '-';

            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td>' . htmlspecialchars($student->name) . '</td>';
            $html .= '<td>' . htmlspecialchars($student->nis) . '</td>';
            $html .= '<td>' . $status . '</td>';
            $html .= '<td>' . $waktu . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'kehadiran_siswa_' . $this->filterDate . '.pdf');
    }

    public function render()
    {
        $data = $this->getAttendanceData();
        $classRoom = $data['classRoom'];
        $students = $data['students'];
        $attendances = $data['attendances'];
        $availableClasses = $data['availableClasses'];
        
        $stats = [
            'hadir' => 0,
            'terlambat' => 0,
            'sakit' => 0,
            'izin' => 0,
            'belum_absen' => 0,
        ];

        if ($classRoom) {
            foreach ($students as $student) {
                $att = $attendances->get($student->id);
                if ($att) {
                    if (isset($stats[$att->status])) {
                        $stats[$att->status]++;
                    }
                } else {
                    $stats['belum_absen']++;
                }
            }
        }

        return view('livewire.guru.dashboard', compact('availableClasses', 'classRoom', 'students', 'attendances', 'stats'));
    }
}
