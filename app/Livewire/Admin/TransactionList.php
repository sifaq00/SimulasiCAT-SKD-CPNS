<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class TransactionList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFrom = '';
    public $dateTo = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function getTransactionsProperty()
    {
        return Transaction::with(['user', 'package', 'bundle'])
            ->when($this->search, fn($q) => $q->whereHas('user', function($uq) {
                $uq->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })->orWhere('invoice_number', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    public function getStatsProperty()
    {
        $query = Transaction::query()
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo));

        return [
            'total' => (clone $query)->count(),
            'paid' => (clone $query)->paid()->count(),
            'pending' => (clone $query)->pending()->count(),
            'revenue' => (clone $query)->paid()->sum('amount'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.transaction-list', [
            'transactions' => $this->transactions,
            'stats' => $this->stats,
        ]);
    }
}
