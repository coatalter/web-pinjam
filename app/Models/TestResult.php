<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_request_id',
        'test_parameter_id',
        'result_value',
        'result_unit',
        'tested_by',
        'tested_at',
        'reviewer_notes',
        'status',
    ];

    protected $casts = [
        'tested_at' => 'datetime',
    ];

    public function testRequest(): BelongsTo
    {
        return $this->belongsTo(TestRequest::class);
    }

    public function testParameter(): BelongsTo
    {
        return $this->belongsTo(TestParameter::class);
    }

    public function tester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tested_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'tested' => 'Sudah Diuji',
            'reviewed' => 'Sudah Direview',
            'approved' => 'Disetujui',
            default => $this->status,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'tested' => 'info',
            'reviewed' => 'primary',
            'approved' => 'success',
            default => 'secondary',
        };
    }
}
