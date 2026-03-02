<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'method',
        'category',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'soil' => 'Tanah',
            'water' => 'Air',
            'plant_tissue' => 'Jaringan Tanaman',
            default => $this->category,
        };
    }
}
