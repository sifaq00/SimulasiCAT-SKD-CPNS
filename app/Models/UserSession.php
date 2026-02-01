<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_token',
        'device_info',
        'ip_address',
        'is_active',
        'last_activity',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_activity' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            if (empty($session->session_token)) {
                $session->session_token = Str::random(64);
            }
        });
    }

    /**
     * Get the user that owns this session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new session for user (invalidating old ones).
     */
    public static function createForUser(User $user): self
    {
        // Invalidate all existing sessions
        self::where('user_id', $user->id)->update(['is_active' => false]);

        return self::create([
            'user_id' => $user->id,
            'device_info' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'is_active' => true,
            'last_activity' => now(),
        ]);
    }

    /**
     * Validate session token.
     */
    public static function validate(string $token): ?self
    {
        return self::where('session_token', $token)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Invalidate this session.
     */
    public function invalidate(): void
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Touch last activity.
     */
    public function touchActivity(): void
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * Scope for active sessions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
