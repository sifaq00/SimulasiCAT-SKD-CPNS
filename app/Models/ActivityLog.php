<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_attempt_id',
        'action',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // Action types
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_TAB_SWITCH = 'tab_switch';
    const ACTION_BLUR = 'blur';
    const ACTION_SCREENSHOT_ATTEMPT = 'screenshot_attempt';
    const ACTION_TEST_START = 'test_start';
    const ACTION_TEST_SUBMIT = 'test_submit';
    const ACTION_ANSWER_SUBMIT = 'answer_submit';

    /**
     * Get the user that owns this log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the test attempt for this log.
     */
    public function testAttempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class);
    }

    /**
     * Log an activity.
     */
    public static function log(
        string $action,
        ?int $userId = null,
        ?int $testAttemptId = null,
        array $metadata = []
    ): self {
        return self::create([
            'user_id' => $userId,
            'test_attempt_id' => $testAttemptId,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Scope for specific action.
     */
    public function scopeOfAction($query, string $action)
    {
        return $query->where('action', $action);
    }
}
