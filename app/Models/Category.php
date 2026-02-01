<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'passing_grade',
        'max_score',
        'question_count',
    ];

    /**
     * Get all questions for this category.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Check if a score passes this category.
     */
    public function isPassing(int $score): bool
    {
        return $score >= $this->passing_grade;
    }
}
