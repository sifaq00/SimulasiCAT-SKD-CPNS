<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'original_price',
        'discount_price',
        'is_active',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get all packages in this bundle.
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'bundle_packages');
    }

    /**
     * Get all transactions for this bundle.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope for active bundles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get discount percentage.
     */
    public function getDiscountPercentageAttribute(): int
    {
        if ($this->original_price <= 0) return 0;
        return round((($this->original_price - $this->discount_price) / $this->original_price) * 100);
    }

    /**
     * Get formatted discount price.
     */
    public function getFormattedDiscountPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->discount_price, 0, ',', '.');
    }
}
