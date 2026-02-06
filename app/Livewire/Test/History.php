<?php

namespace App\Livewire\Test;

use App\Models\TestAttempt;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
    use WithPagination;

    public function render()
    {
        $attempts = TestAttempt::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with(['package', 'transaction'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.test.history', [
            'attempts' => $attempts
        ])->layout('layouts.app');
    }
}
