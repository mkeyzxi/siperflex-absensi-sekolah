<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'npsn', 'address', 'phone', 'email', 'logo_path',
        'latitude', 'longitude', 'geofence_radius', 'geofence_enabled',
        'timezone', 'is_active', 'status'
    ];

    protected $casts = [
        'geofence_enabled' => 'boolean',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }

    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }
}
