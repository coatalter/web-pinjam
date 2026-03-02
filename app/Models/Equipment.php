<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'code',
        'description',
        'room_id',
        'category',
        'is_available',
        'condition',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function practicumRegistrations(): BelongsToMany
    {
        return $this->belongsToMany(PracticumRegistration::class, 'practicum_equipment')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            default => $this->condition,
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'general' => 'Umum',
            'soil' => 'Tanah',
            'water' => 'Air',
            'plant_tissue' => 'Jaringan Tanaman',
            default => $this->category,
        };
    }
}
