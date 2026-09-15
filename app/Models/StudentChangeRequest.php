<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'student_id',
        'requested_data',
        'status',
        'notes',
        'admin_id'
    ];

    protected $casts = [
        'requested_data' => 'array',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
