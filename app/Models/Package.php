<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'year',
        'price',
        'bundle_price',
        'total_questions',
        'duration_minutes',
        'is_active',
        'is_free',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'bundle_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_free' => 'boolean',
    ];

    /**
     * Get all questions for this package.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all test attempts for this package.
     */
    public function testAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    /**
     * Get all transactions for this package.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the bundles that include this package.
     */
    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(Bundle::class, 'bundle_packages');
    }

    /**
     * Scope for active packages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
