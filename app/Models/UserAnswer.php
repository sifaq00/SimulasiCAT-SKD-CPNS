<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_attempt_id',
        'question_id',
        'selected_option_id',
        'is_correct',
        'points_earned',
        'time_spent_seconds',
        'is_bookmarked',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_bookmarked' => 'boolean',
    ];

    /**
     * Get the test attempt that owns this answer.
     */
    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class);
    }

    /**
     * Get the question for this answer.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the selected option.
     */
    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'selected_option_id');
    }

    /**
     * Calculate and set points for this answer.
     */
    public function calculatePoints(): void
    {
        $question = $this->question()->with('category', 'options')->first();
        
        if (!$question || !$this->selected_option_id) {
            $this->update([
                'is_correct' => false,
                'points_earned' => 0,
            ]);
            return;
        }

        $categoryCode = $question->category->code ?? '';
        
        if ($categoryCode === 'TKP') {
            // TKP uses points from option (1-5)
            $option = $question->options->find($this->selected_option_id);
            $points = $option ? $option->points : 0;
            
            $this->update([
                'is_correct' => $points === 5, // 5 is max for TKP
                'points_earned' => $points,
            ]);
        } else {
            // TWK/TIU: correct = 5 points, wrong = 0
            // Check correct_option_id first, then fallback to is_correct on options
            $isCorrect = false;
            
            if ($question->correct_option_id) {
                $isCorrect = $question->correct_option_id === $this->selected_option_id;
            } else {
                $selectedOption = $question->options->find($this->selected_option_id);
                $isCorrect = $selectedOption ? $selectedOption->is_correct : false;
            }
            
            $this->update([
                'is_correct' => $isCorrect,
                'points_earned' => $isCorrect ? 5 : 0,
            ]);
        }
    }

    /**
     * Toggle bookmark status.
     */
    public function toggleBookmark(): bool
    {
        $this->update(['is_bookmarked' => !$this->is_bookmarked]);
        return $this->is_bookmarked;
    }
}
