<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'category_id',
        'question_text',
        'question_image',
        'explanation',
        'correct_option_id',
        'points',
        'order_number',
    ];

    /**
     * Get the package that owns this question.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the category for this question.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all options for this question.
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class)->orderBy('label');
    }

    /**
     * Get the correct option.
     */
    public function correctOption(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'correct_option_id');
    }

    /**
     * Get all user answers for this question.
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    /**
     * Check if an option is correct (for TWK/TIU).
     */
    public function isCorrect(int $optionId): bool
    {
        return $this->correct_option_id === $optionId;
    }

    /**
     * Get points for an option (for TKP).
     */
    public function getPointsForOption(int $optionId): int
    {
        $option = $this->options()->find($optionId);
        return $option ? $option->points : 0;
    }
}
