<?php

namespace App\Livewire\Test;

use App\Models\Package;
use App\Models\TestAttempt;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.exam')]
class FreeResult extends Component
{
    public $result = [];
    public $showReview = false;
    public $reviewData = [];

    public function mount()
    {
        $answers = session('free_tryout_answers');
        if (!$answers && !session()->has('free_tryout_started_at')) {
            return redirect()->route('home');
        }

        $this->calculateResult();
    }

    private function calculateResult()
    {
        $answers = session('free_tryout_answers', []);
        $questionIds = array_keys($answers);

        $questions = \App\Models\Question::with(['category', 'options'])
            ->whereIn('id', $questionIds)
            ->get();

        $scores = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0];
        $correctCount = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0];
        $totalPerCat = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0];

        // Need to know how many questions were in the free test for max score calculation
        // Let's assume all 30 were attempted or available.
        // For a more accurate "Max Score", we should fetch all 30 questions.
        $package = Package::active()->where('is_free', true)->first();
        if (!$package)
            return;

        $allFreeQuestions = $package->questions()->with('category')->limit($package->total_questions ?? 110)->get();

        foreach ($allFreeQuestions as $q) {
            $cat = $q->category->code ?? 'OTHER';
            if (isset($totalPerCat[$cat]))
                $totalPerCat[$cat]++;
        }

        foreach ($questions as $q) {
            $cat = $q->category->code ?? 'OTHER';
            $selectedOptionId = $answers[$q->id] ?? null;

            if (!$selectedOptionId)
                continue;

            if ($cat === 'TKP') {
                $option = $q->options->find($selectedOptionId);
                $points = $option ? $option->points : 0;
                $scores['TKP'] += $points;
                if ($points === 5)
                    $correctCount['TKP']++;
            } else {
                $isCorrect = ($q->correct_option_id == $selectedOptionId);
                if (!$isCorrect && !$q->correct_option_id) {
                    $opt = $q->options->find($selectedOptionId);
                    $isCorrect = $opt ? $opt->is_correct : false;
                }

                if ($isCorrect) {
                    $scores[$cat] += 5;
                    $correctCount[$cat]++;
                }
            }
        }

        $totalScore = array_sum($scores);

        $startedAt = session('free_tryout_started_at');
        // If it's a Carbon instance or string, handle it
        if (!$startedAt instanceof \Carbon\Carbon) {
            $startedAt = \Carbon\Carbon::parse($startedAt);
        }

        $finishedAt = now();
        $durationMinutes = $startedAt->diffInMinutes($finishedAt);

        $this->result = [
            'package' => $package->name . ' (Latihan Gratis)',
            'scores' => [
                'twk' => [
                    'score' => $scores['TWK'],
                    'passing_grade' => TestAttempt::PASSING_GRADE_TWK,
                    'max_score' => 150,
                    'passed' => $scores['TWK'] >= TestAttempt::PASSING_GRADE_TWK,
                    'count' => $correctCount['TWK'],
                ],
                'tiu' => [
                    'score' => $scores['TIU'],
                    'passing_grade' => TestAttempt::PASSING_GRADE_TIU,
                    'max_score' => 175,
                    'passed' => $scores['TIU'] >= TestAttempt::PASSING_GRADE_TIU,
                    'count' => $correctCount['TIU'],
                ],
                'tkp' => [
                    'score' => $scores['TKP'],
                    'passing_grade' => TestAttempt::PASSING_GRADE_TKP,
                    'max_score' => 225,
                    'passed' => $scores['TKP'] >= TestAttempt::PASSING_GRADE_TKP,
                    'count' => $correctCount['TKP'],
                ],
            ],
            'total_score' => $totalScore,
            'max_total_score' => 550,
            'passed_overall' => $scores['TWK'] >= TestAttempt::PASSING_GRADE_TWK
                && $scores['TIU'] >= TestAttempt::PASSING_GRADE_TIU
                && $scores['TKP'] >= TestAttempt::PASSING_GRADE_TKP,
            'package_total_questions' => Package::active()->where('is_free', false)->first()?->total_questions ?? 110,
            'answers' => $answers,
            'started_at' => $startedAt->format('d M Y, H:i'),
            'finished_at' => $finishedAt->format('d M Y, H:i'),
            'duration_minutes' => $durationMinutes,
            'tab_switch_count' => 0, // Guest doesn't have strict tracking yet
        ];
    }

    public function toggleReview()
    {
        $this->showReview = !$this->showReview;

        if ($this->showReview && empty($this->reviewData)) {
            $answers = session('free_tryout_answers', []);
            $package = Package::active()->where('is_free', true)->first();
            if (!$package)
                return;

            $questions = $package->questions()
                ->with(['options', 'category'])
                ->limit(30)
                ->get();

            $this->reviewData = $questions->map(function ($q) use ($answers) {
                return [
                    'number' => $q->order_number,
                    'category' => $q->category->code ?? '',
                    'question_text' => $q->question_text,
                    'question_image' => $q->question_image,
                    'options' => $q->options->map(fn($opt) => [
                        'id' => $opt->id,
                        'label' => $opt->label,
                        'text' => $opt->option_text,
                        'is_correct' => ($q->category->code === 'TKP' ? $opt->points === 5 : ($q->correct_option_id ? $q->correct_option_id == $opt->id : $opt->is_correct)),
                        'points' => $opt->points,
                    ]),
                    'selected_option_id' => $answers[$q->id] ?? null,
                    'explanation' => $q->explanation,
                ];
            })->toArray();
        }
    }

    public function restart()
    {
        session()->forget(['free_tryout_started_at', 'free_tryout_answers', 'free_tryout_bookmarks', 'free_tryout_completed']);
        return redirect()->route('test.free-simulation');
    }

    public function render()
    {
        return view('livewire.test.free-result');
    }
}
