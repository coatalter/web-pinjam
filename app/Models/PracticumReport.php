<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticumReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'practicum_registration_id',
        'title',
        'report_file',
        'submitted_by',
        'submitted_at',
        'grade',
        'notes',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function practicumRegistration(): BelongsTo
    {
        return $this->belongsTo(PracticumRegistration::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
