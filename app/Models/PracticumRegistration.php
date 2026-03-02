<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticumRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_name',
        'class_name',
        'lecturer_name',
        'semester',
        'academic_year',
        'room_id',
        'schedule_date',
        'start_time',
        'end_time',
        'num_students',
        'status',
        'notes',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'num_students' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'practicum_equipment')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(PracticumReport::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'registered' => 'Terdaftar',
            'in_progress' => 'Berlangsung',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'registered' => 'info',
            'in_progress' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }
}
