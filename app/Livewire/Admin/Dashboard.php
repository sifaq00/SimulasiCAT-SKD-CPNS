<?php

namespace App\Livewire\Admin;

use App\Models\Package;
use App\Models\Question;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public $stats = [];
    public $recentTransactions = [];
    public $recentUsers = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentTransactions();
        $this->loadRecentUsers();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_users' => User::count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_packages' => Package::count(),
            'total_questions' => Question::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::paid()->sum('amount'),
            'today_transactions' => Transaction::whereDate('created_at', today())->count(),
            'today_revenue' => Transaction::paid()->whereDate('created_at', today())->sum('amount'),
            'pending_transactions' => Transaction::pending()->count(),
        ];
    }

    public function loadRecentTransactions()
    {
        $this->recentTransactions = Transaction::with(['user', 'package'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($t) => [
                'id' => $t->id,
                'invoice' => $t->invoice_number,
                'user' => $t->user->name,
                'package' => $t->package?->name ?? $t->bundle?->name ?? '-',
                'amount' => 'Rp ' . number_format($t->amount, 0, ',', '.'),
                'status' => $t->status,
                'date' => $t->created_at->format('d M Y H:i'),
            ])
            ->toArray();
    }

    public function loadRecentUsers()
    {
        $this->recentUsers = User::orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role,
                'verified' => $u->hasVerifiedEmail(),
                'date' => $u->created_at->format('d M Y'),
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
