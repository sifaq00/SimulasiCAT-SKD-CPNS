<?php

namespace App\Livewire\Test;

use App\Models\TestAttempt;
use App\Services\TestService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Result extends Component
{
    public TestAttempt $attempt;
    public $result = [];
    public $showReview = false;
    public $reviewData = [];

    protected TestService $testService;

    public function boot(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function mount(int $attemptId)
    {
        $this->attempt = TestAttempt::with('package')->find($attemptId);

        if (!$this->attempt) {
            abort(404, 'Test attempt not found: ' . $attemptId);
        }

        if ($this->attempt->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to test attempt. Attempt User: ' . $this->attempt->user_id . ', Current User: ' . auth()->id());
        }

        if ($this->attempt->isInProgress()) {
            return redirect()->route('test.simulation', [
                'packageSlug' => $this->attempt->package->slug,
                'transactionId' => $this->attempt->transaction_id,
            ]);
        }

        $this->result = $this->testService->getResult($this->attempt);
    }

    public function toggleReview()
    {
        $this->showReview = !$this->showReview;
        
        if ($this->showReview && empty($this->reviewData)) {
            $this->reviewData = $this->testService->getReviewData($this->attempt)->toArray();
        }
    }

    public function render()
    {
        return view('livewire.test.result');
    }
}
