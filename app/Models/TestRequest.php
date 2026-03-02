<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_code',
        'sample_type',
        'sample_description',
        'num_samples',
        'parameters',
        'status',
        'notes',
        'payment_proof',
        'payment_verified_at',
        'payment_verified_by',
        'assigned_tester_id',
        'assigned_reviewer_id',
        'report_file',
        'report_approved_by',
        'report_approved_at',
        'report_sent_at',
    ];

    protected $casts = [
        'parameters' => 'array',
        'payment_verified_at' => 'datetime',
        'report_approved_at' => 'datetime',
        'report_sent_at' => 'datetime',
        'num_samples' => 'integer',
    ];

    // ── Relationships ──────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_tester_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_reviewer_id');
    }

    public function paymentVerifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    public function reportApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'report_approved_by');
    }

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    // ── Scopes ─────────────────────────────────

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // ── Helpers ─────────────────────────────────

    public static function generateCode(): string
    {
        $prefix = 'REQ-' . date('Ymd');
        $lastRequest = static::where('request_code', 'like', $prefix . '%')
            ->orderByDesc('request_code')
            ->first();

        if ($lastRequest) {
            $lastNumber = (int) substr($lastRequest->request_code, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . '-' . $nextNumber;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'warning',
            'payment_uploaded' => 'info',
            'payment_verified' => 'primary',
            'in_testing' => 'indigo',
            'in_review' => 'purple',
            'report_approved' => 'success',
            'completed' => 'success',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'payment_uploaded' => 'Bukti Bayar Diunggah',
            'payment_verified' => 'Pembayaran Terverifikasi',
            'in_testing' => 'Dalam Pengujian',
            'in_review' => 'Dalam Review',
            'report_approved' => 'Laporan Disetujui',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }

    public function getSampleTypeLabelAttribute(): string
    {
        return match ($this->sample_type) {
            'tanah' => 'Tanah',
            'air' => 'Air',
            'jaringan_tanaman' => 'Jaringan Tanaman',
            default => $this->sample_type,
        };
    }

    /**
     * Calculate total price based on selected parameters.
     */
    public function getTotalPriceAttribute(): float
    {
        if (empty($this->parameters)) {
            return 0;
        }

        return TestParameter::whereIn('id', $this->parameters)->sum('price') * $this->num_samples;
    }
}
