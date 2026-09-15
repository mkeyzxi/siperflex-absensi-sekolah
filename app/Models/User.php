<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'email',
        'username',
        'nis',
        'nip',
        'password',
        'profile_photo_path',
        'role',
        'is_active',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    // Guru relationships
    public function assignedClasses()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_teacher', 'teacher_id', 'class_id')->withTimestamps();
    }
    
    // Siswa relationships
    public function studentClasses()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_student', 'student_id', 'class_id')->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function changeRequests()
    {
        return $this->hasMany(StudentChangeRequest::class, 'student_id');
    }
}
