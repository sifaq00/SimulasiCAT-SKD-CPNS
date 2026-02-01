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
                ];
            })
            ->toArray();
    }

    public function loadPurchasedPackages()
    {
        $transactions = $this->user->transactions()
            ->with(['package', 'bundle.packages'])
            ->where('status', Transaction::STATUS_PAID)
            ->get();

        $packages = collect();

        // Get IDs of packages that have been completed
        $completedPackageIds = $this->user->testAttempts()
            ->whereIn('status', [TestAttempt::STATUS_COMPLETED, TestAttempt::STATUS_TIMEOUT])
            ->pluck('package_id')
            ->toArray();

        foreach ($transactions as $transaction) {
            // Processing single package purchase
            if ($transaction->package) {
                // Skip if this package is already completed
                if (in_array($transaction->package_id, $completedPackageIds)) {
                    continue;
                }

                $packages->push([
                    'transaction_id' => $transaction->id,
                    'package_name' => $transaction->package->name,
                    'package_slug' => $transaction->package->slug,
                    'package_year' => $transaction->package->year,
                    'purchased_at' => $transaction->paid_at?->format('d M Y') ?? $transaction->created_at->format('d M Y'),
                    'is_bundle' => false,
                ]);
            }
            
            // Processing bundle purchase
            if ($transaction->bundle) {
                foreach ($transaction->bundle->packages as $pkg) {
                    // Skip if this specific package in the bundle is completed
                    if (in_array($pkg->id, $completedPackageIds)) {
                        continue;
                    }

                    $packages->push([
                        'transaction_id' => $transaction->id, // Use bundle transaction id
                        'package_name' => $pkg->name,
                        'package_slug' => $pkg->slug,
                        'package_year' => $pkg->year,
                        'purchased_at' => $transaction->paid_at?->format('d M Y') ?? $transaction->created_at->format('d M Y'),
                        'is_bundle' => true,
                        'bundle_name' => $transaction->bundle->name,
                    ]);
                }
            }
        }
        
        $this->purchasedPackages = $packages->unique(function ($item) {
            return $item['package_slug'];
        })->values()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
