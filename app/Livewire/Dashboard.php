<?php

namespace App\Livewire;

use App\Models\TestAttempt;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $stats = [];
    public $recentAttempts = [];
    public $purchasedPackages = [];
    public $user;

    public function mount()
    {
        $this->user = auth()->user();

        // 1. Check for ongoing paid exam
        // If user has an active attempt, force redirect to exam page
        $ongoingAttempt = $this->user->testAttempts()
            ->with(['package', 'transaction'])
            ->where('status', TestAttempt::STATUS_IN_PROGRESS)
            ->whereNotNull('transaction_id') // Only for paid exams (Free is session-based)
            ->latest('started_at')
            ->first();

        // Check if attempt exists and time hasn't effectively expired
        if (
            $ongoingAttempt &&
            $ongoingAttempt->package &&
            $ongoingAttempt->transaction &&
            !$ongoingAttempt->hasTimeExpired()
        ) {
            return redirect()->route('test.simulation', [
                'packageSlug' => $ongoingAttempt->package->slug,
                'transactionId' => $ongoingAttempt->transaction->id,
            ]);
        }

        $this->loadStats();
        $this->loadRecentAttempts();
        $this->loadPurchasedPackages();
    }

    public function loadStats()
    {
        $attempts = $this->user->testAttempts()->completed();

        $this->stats = [
            'total_tests' => $attempts->count(),
            'average_score' => round($attempts->avg('total_score') ?? 0),
            'highest_score' => $attempts->max('total_score') ?? 0,
            'passed_count' => $attempts->where('passed_overall', true)->count(),
            'total_spent' => $this->user->transactions()->paid()->sum('amount'),
            'highest_twk' => $attempts->max('score_twk') ?? 0,
            'highest_tiu' => $attempts->max('score_tiu') ?? 0,
            'highest_tkp' => $attempts->max('score_tkp') ?? 0,
        ];
    }

    public function loadRecentAttempts()
    {
        $this->recentAttempts = $this->user->testAttempts()
            ->with('package')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($attempt) {
                return [
                    'id' => $attempt->id,
                    'package_name' => $attempt->package->name,
                    'total_score' => $attempt->total_score,
                    'passed' => $attempt->passed_overall,
                    'status' => $attempt->status,
                    'date' => $attempt->created_at->format('d M Y'),
                    'score_twk' => $attempt->score_twk,
                    'score_tiu' => $attempt->score_tiu,
                    'score_tkp' => $attempt->score_tkp,
                ];
            })
            ->toArray();
    }

    public function loadPurchasedPackages()
    {
        $transactions = $this->user->transactions()
            ->with(['package', 'bundle.packages', 'testAttempts'])
            ->where('status', Transaction::STATUS_PAID)
            ->get();

        $packages = collect();

        foreach ($transactions as $transaction) {
            // Processing single package purchase
            if ($transaction->package) {
                $pkg = $transaction->package;

                // Get attempt for THIS transaction and THIS package
                $attempt = $transaction->testAttempts
                    ->where('package_id', $pkg->id)
                    ->first();

                // Skip if this package is already completed FOR THIS TRANSACTION
                if ($attempt && in_array($attempt->status, [TestAttempt::STATUS_COMPLETED, TestAttempt::STATUS_TIMEOUT])) {
                    continue;
                }

                $packages->push([
                    'transaction_id' => $transaction->id,
                    'package_name' => $pkg->name,
                    'package_slug' => $pkg->slug,
                    'package_year' => $pkg->year,
                    'purchased_at' => $transaction->paid_at?->format('d M Y') ?? $transaction->created_at->format('d M Y'),
                    'is_bundle' => false,
                    'status' => $attempt?->status ?? 'new',
                ]);
            }

            // Processing bundle purchase
            if ($transaction->bundle) {
                foreach ($transaction->bundle->packages as $pkg) {
                    // Check attempt for THIS transaction and THIS package in the bundle
                    $attempt = $transaction->testAttempts
                        ->where('package_id', $pkg->id)
                        ->first();

                    // Skip if this specific package in the bundle is completed FOR THIS TRANSACTION
                    if ($attempt && in_array($attempt->status, [TestAttempt::STATUS_COMPLETED, TestAttempt::STATUS_TIMEOUT])) {
                        continue;
                    }

                    $packages->push([
                        'transaction_id' => $transaction->id,
                        'package_name' => $pkg->name,
                        'package_slug' => $pkg->slug,
                        'package_year' => $pkg->year,
                        'purchased_at' => $transaction->paid_at?->format('d M Y') ?? $transaction->created_at->format('d M Y'),
                        'is_bundle' => true,
                        'bundle_name' => $transaction->bundle->name,
                        'status' => $attempt?->status ?? 'new',
                    ]);
                }
            }
        }

        // Use unique to avoid showing the same package twice if bought multiple times
        // But keep the most "advanced" status (in_progress over new)
        $this->purchasedPackages = $packages->sortByDesc(function ($item) {
            return $item['status'] === 'in_progress' ? 1 : 0;
        })->unique(function ($item) {
            return $item['package_slug'];
        })->values()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
