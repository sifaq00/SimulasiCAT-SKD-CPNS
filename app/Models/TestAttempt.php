<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'transaction_id',
        'started_at',
        'finished_at',
        'score_twk',
        'score_tiu',
        'score_tkp',
        'total_score',
        'passed_twk',
        'passed_tiu',
        'passed_tkp',
        'passed_overall',
        'tab_switch_count',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'passed_twk' => 'boolean',
        'passed_tiu' => 'boolean',
        'passed_tkp' => 'boolean',
        'passed_overall' => 'boolean',
    ];

    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_ABANDONED = 'abandoned';
    const STATUS_TIMEOUT = 'timeout';

    const PASSING_GRADE_TWK = 65;
    const PASSING_GRADE_TIU = 80;
    const PASSING_GRADE_TKP = 166;

    /**
     * Get the user that owns this attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the package for this attempt.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the transaction for this attempt.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get all user answers for this attempt.
     */
    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    /**
     * Get activity logs for this attempt.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check if test is still in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    /**
     * Check if test is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Get remaining time in seconds.
     */
    public function getRemainingTimeAttribute(): int
    {
        if (!$this->started_at || !$this->isInProgress()) {
            return 0;
        }

        $durationSeconds = $this->package->duration_minutes * 60;
        $endTime = $this->started_at->addSeconds($durationSeconds);
        $remaining = $endTime->diffInSeconds(now(), false);

        return max(0, -$remaining);
    }

    /**
     * Check if time has expired.
     */
    public function hasTimeExpired(): bool
    {
        return $this->remaining_time <= 0 && $this->isInProgress();
    }

    /**
     * Calculate scores from answers.
     */
    public function calculateScores(): void
    {
        $answers = $this->userAnswers()->with('question.category')->get();
        
        $scores = [
            'TWK' => 0,
            'TIU' => 0,
            'TKP' => 0,
        ];

        foreach ($answers as $answer) {
            $categoryCode = $answer->question->category->code ?? '';
            if (isset($scores[$categoryCode])) {
                $scores[$categoryCode] += $answer->points_earned;
            }
        }

        $this->update([
            'score_twk' => $scores['TWK'],
            'score_tiu' => $scores['TIU'],
            'score_tkp' => $scores['TKP'],
            'total_score' => array_sum($scores),
            'passed_twk' => $scores['TWK'] >= self::PASSING_GRADE_TWK,
            'passed_tiu' => $scores['TIU'] >= self::PASSING_GRADE_TIU,
            'passed_tkp' => $scores['TKP'] >= self::PASSING_GRADE_TKP,
            'passed_overall' => $scores['TWK'] >= self::PASSING_GRADE_TWK 
                && $scores['TIU'] >= self::PASSING_GRADE_TIU 
                && $scores['TKP'] >= self::PASSING_GRADE_TKP,
        ]);
    }

    /**
     * Complete the test.
     */
    public function complete(): void
    {
        $this->calculateScores();
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'finished_at' => now(),
        ]);
    }

    /**
     * Increment tab switch count.
     */
    public function incrementTabSwitchCount(): void
    {
        $this->increment('tab_switch_count');
    }

    /**
     * Scope for completed attempts.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for in progress attempts.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }
}
