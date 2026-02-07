<?php

namespace App\Livewire\Test;

use App\Models\Package;
use App\Models\TestAttempt;
use App\Models\Transaction;
use App\Services\TestService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.exam')]
class Simulation extends Component
{
    public Package $package;
    public TestAttempt $attempt;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $remainingTime = 0;
    public $navigation = [];
    public $showWarning = false;
    public $warningMessage = '';
    public $tabSwitchCount = 0;

    /**
     * Livewire listeners for client events
     */
    protected $listeners = [
        'recordTabSwitch' => 'recordTabSwitch',
    ];

    protected TestService $testService;

    public function boot(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function mount(string $packageSlug, int $transactionId)
    {
        $this->package = Package::where('slug', $packageSlug)->firstOrFail();
        $transaction = Transaction::where('id', $transactionId)
            ->where('user_id', Auth::user()->id)
            ->where('status', Transaction::STATUS_PAID)
            ->firstOrFail();

        // Start or resume test
        $this->attempt = $this->testService->startTest(
            Auth::user(),
            $this->package,
            $transaction
        );

        $this->loadQuestions();
        $this->loadNavigation();
        $this->calculateRemainingTime();
        $this->tabSwitchCount = $this->attempt->tab_switch_count;
    }

    public function loadQuestions()
    {
        $this->questions = $this->testService->getQuestions($this->attempt)->toArray();
    }

    public function loadNavigation()
    {
        $this->navigation = $this->testService->getNavigationData($this->attempt);
    }

    public function calculateRemainingTime()
    {
        $this->remainingTime = $this->attempt->remaining_time;
    }

    public function getCurrentQuestion()
    {
        return $this->questions[$this->currentQuestionIndex] ?? null;
    }

    public function goToQuestion(int $index)
    {
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentQuestionIndex = $index;
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function selectAnswer(int $optionId)
    {
        $question = $this->getCurrentQuestion();
        if (!$question)
            return;

        try {
            $this->testService->submitAnswer($this->attempt, $question['id'], $optionId);

            // Update local state
            $this->questions[$this->currentQuestionIndex]['selected_option_id'] = $optionId;

            // Refresh the attempt to get fresh userAnswers
            $this->loadNavigation();
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'expired')) {
                $this->submitTest();
            }
            $this->showWarning = true;
            $this->warningMessage = $e->getMessage();
        }
    }

    public function toggleBookmark()
    {
        $question = $this->getCurrentQuestion();
        if (!$question)
            return;

        $isBookmarked = $this->testService->toggleBookmark($this->attempt, $question['id']);
        $this->questions[$this->currentQuestionIndex]['is_bookmarked'] = $isBookmarked;
        $this->loadNavigation();
    }

    public function recordTabSwitch()
    {
        $this->tabSwitchCount = $this->testService->recordTabSwitch($this->attempt);

        $this->showWarning = true;
        $this->warningMessage = 'Anda terdeteksi membuka tab/aplikasi lain! Peringatan ke-' . $this->tabSwitchCount;
    }

    public function submitTest()
    {
        try {
            $this->testService->submitTest($this->attempt);
            return redirect()->route('test.result', $this->attempt->id);
        } catch (\Exception $e) {
            $this->showWarning = true;
            $this->warningMessage = $e->getMessage();
        }
    }

    public function timeExpired()
    {
        $this->testService->autoSubmit($this->attempt);
        return redirect()->route('test.result', $this->attempt->id);
    }

    public function dismissWarning()
    {
        $this->showWarning = false;
        $this->warningMessage = '';
    }

    public function render()
    {
        return view('livewire.test.simulation', [
            'currentQuestion' => $this->getCurrentQuestion(),
            'totalQuestions' => count($this->questions),
            'user' => Auth::user(),
        ]);
    }
}
