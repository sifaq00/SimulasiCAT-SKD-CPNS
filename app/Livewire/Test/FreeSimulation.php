<?php

namespace App\Livewire\Test;

use App\Models\Package;
use App\Models\Question;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.exam')]
class FreeSimulation extends Component
{
    public ?Package $package = null;
    public $questions = [];
    public $currentQuestionIndex = 0;
    public $remainingTime = 0;
    public $navigation = [];

    protected $listeners = [
        'timeExpired' => 'timeExpired',
    ];

    public function mount()
    {
        $package = Package::active()->where('is_free', true)->first();

        if (!$package) {
            return redirect()->route('home')->with('error', 'Maaf, latihan gratis sedang tidak tersedia.');
        }

        // Reset session if an older attempt was already completed
        if (session('free_tryout_completed')) {
            $this->forceReset();
        }

        $this->package = $package;

        $this->loadQuestions();
        $this->initSession();
        $this->loadNavigation();
        $this->calculateRemainingTime();
    }

    private function loadQuestions()
    {
        if (!$this->package)
            return;

        // Load exactly 30 questions as requested (or all if less than 30)
        $this->questions = $this->package->questions()
            ->with(['options', 'category'])
            ->orderBy('order_number')
            ->limit($this->package->total_questions ?? 110)
            ->get()
            ->map(function ($q) {
                $answers = session('free_tryout_answers', []);
                $bookmarks = session('free_tryout_bookmarks', []);
                return [
                    'id' => $q->id,
                    'number' => $q->order_number,
                    'category' => $q->category->code ?? 'N/A',
                    'category_name' => $q->category->name ?? 'N/A',
                    'question_text' => $q->question_text,
                    'question_image' => $q->question_image,
                    'options' => $q->options->map(fn($opt) => [
                        'id' => $opt->id,
                        'label' => $opt->label,
                        'text' => $opt->option_text,
                    ])->toArray(),
                    'selected_option_id' => $answers[$q->id] ?? null,
                    'is_bookmarked' => in_array($q->id, $bookmarks),
                ];
            })->toArray();
    }

    public function loadNavigation()
    {
        $answers = session('free_tryout_answers', []);
        $bookmarks = session('free_tryout_bookmarks', []);

        // Group questions by category
        $grouped = [];
        foreach ($this->questions as $q) {
            $catName = $q['category_name'];
            if (!isset($grouped[$catName])) {
                $grouped[$catName] = [
                    'name' => $catName,
                    'questions' => [],
                ];
            }
            $grouped[$catName]['questions'][] = [
                'number' => $q['number'],
                'is_answered' => isset($answers[$q['id']]),
                'is_bookmarked' => in_array($q['id'], $bookmarks),
            ];
        }

        $this->navigation = [
            'categories' => array_values($grouped),
            'answered_count' => count($answers),
            'bookmarked_count' => count($bookmarks),
        ];
    }

    private function initSession()
    {
        if (!session()->has('free_tryout_started_at')) {
            session(['free_tryout_started_at' => now()]);
            session(['free_tryout_answers' => []]);
            session(['free_tryout_bookmarks' => []]);
        }
    }

    public function calculateRemainingTime()
    {
        $startedAt = session('free_tryout_started_at');
        $durationSeconds = $this->package->duration_minutes * 60;
        $endTime = $startedAt->copy()->addSeconds($durationSeconds);
        $this->remainingTime = (int) max(0, $endTime->diffInSeconds(now(), false) * -1);

        if ($this->remainingTime <= 0) {
            $this->submitTest();
        }
    }

    public function selectAnswer($optionId)
    {
        $questionId = $this->questions[$this->currentQuestionIndex]['id'];
        $answers = session('free_tryout_answers', []);
        $answers[$questionId] = $optionId;
        session(['free_tryout_answers' => $answers]);

        $this->questions[$this->currentQuestionIndex]['selected_option_id'] = $optionId;
        $this->loadNavigation();
    }

    public function toggleBookmark()
    {
        $questionId = $this->questions[$this->currentQuestionIndex]['id'];
        $bookmarks = session('free_tryout_bookmarks', []);

        if (in_array($questionId, $bookmarks)) {
            $bookmarks = array_diff($bookmarks, [$questionId]);
            $this->questions[$this->currentQuestionIndex]['is_bookmarked'] = false;
        } else {
            $bookmarks[] = $questionId;
            $this->questions[$this->currentQuestionIndex]['is_bookmarked'] = true;
        }

        session(['free_tryout_bookmarks' => $bookmarks]);
        $this->loadNavigation();
    }

    public function goToQuestion($index)
    {
        if (isset($this->questions[$index])) {
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


    public function timeExpired()
    {
        return $this->submitTest();
    }

    private function forceReset()
    {
        session()->forget([
            'free_tryout_started_at',
            'free_tryout_answers',
            'free_tryout_bookmarks',
            'free_tryout_completed'
        ]);
        $this->currentQuestionIndex = 0;
    }

    public function submitTest()
    {
        session(['free_tryout_completed' => true]);
        return redirect()->route('test.free-result');
    }

    public function render()
    {
        return view('livewire.test.free-simulation', [
            'currentQuestion' => $this->questions[$this->currentQuestionIndex] ?? null,
            'totalQuestions' => count($this->questions),
            'answeredCount' => count(session('free_tryout_answers', [])),
            'bookmarkedCount' => count(session('free_tryout_bookmarks', [])),
        ]);
    }
}
