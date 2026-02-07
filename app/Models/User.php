<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'phone_verified_at',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get all transactions for this user.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get all test attempts for this user.
     */
    public function testAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    /**
     * Get activity logs for this user.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get user sessions.
     */
    public function userSessions(): HasMany
    {
        return $this->hasMany(UserSession::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if phone is verified.
     */
    public function hasVerifiedPhone(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    /**
     * Mark phone as verified.
     */
    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Check if user is fully verified (email AND phone).
     */
    public function isFullyVerified(): bool
    {
        return $this->hasVerifiedEmail() && $this->hasVerifiedPhone();
    }

    /**
     * Check if user has access to a package (has paid transaction and not yet completed it).
     */
    public function hasAccessToPackage(int $packageId): bool
    {
        return $this->transactions()
            ->where('status', Transaction::STATUS_PAID)
            ->where(function ($query) use ($packageId) {
                $query->where('package_id', $packageId)
                    ->orWhereHas('bundle.packages', function ($q) use ($packageId) {
                        $q->where('packages.id', $packageId);
                    });
            })
            ->whereDoesntHave('testAttempts', function ($query) use ($packageId) {
                $query->where('package_id', $packageId)
                    ->whereIn('status', [
                        TestAttempt::STATUS_COMPLETED,
                        TestAttempt::STATUS_TIMEOUT,
                    ]);
            })
            ->exists();
    }

    /**
     * Get completed test count.
     */
    public function getCompletedTestCountAttribute(): int
    {
        return $this->testAttempts()->completed()->count();
    }

    /**
     * Get average score.
     */
    public function getAverageScoreAttribute(): float
    {
        return $this->testAttempts()
            ->completed()
            ->avg('total_score') ?? 0;
    }

    /**
     * Get highest score.
     */
    public function getHighestScoreAttribute(): int
    {
        return $this->testAttempts()
            ->completed()
            ->max('total_score') ?? 0;
    }

    /**
     * Scope for active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification (queued for async).
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification);
    }
}
