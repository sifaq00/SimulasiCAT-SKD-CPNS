<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Question;
use App\Models\TestAttempt;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\ActivityLog;
use Exception;
use Illuminate\Support\Collection;

class TestService
{
    /**
     * Start a new test attempt.
     */
    public function startTest(User $user, Package $package, Transaction $transaction): TestAttempt
    {
        // Check if there's already an in-progress attempt
        $existingAttempt = TestAttempt::where('user_id', $user->id)
            ->where('package_id', $package->id)
            ->where('transaction_id', $transaction->id)
            ->where('status', TestAttempt::STATUS_IN_PROGRESS)
            ->first();

        if ($existingAttempt) {
            return $existingAttempt;
        }

        // Create new test attempt
        $attempt = TestAttempt::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'transaction_id' => $transaction->id,
            'started_at' => now(),
            'status' => TestAttempt::STATUS_IN_PROGRESS,
        ]);

        // Pre-create empty answers for all questions
        $questions = $package->questions()->orderBy('order_number')->get();
        foreach ($questions as $question) {
            UserAnswer::create([
                'test_attempt_id' => $attempt->id,
                'question_id' => $question->id,
            ]);
        }

        // Log activity
        ActivityLog::log(ActivityLog::ACTION_TEST_START, $user->id, $attempt->id, [
            'package_id' => $package->id,
        ]);

        return $attempt;
    }

    /**
     * Get questions for a test attempt.
     */
    public function getQuestions(TestAttempt $attempt): Collection
    {
        // Eager load everything needed
        $userAnswers = $attempt->userAnswers->keyBy('question_id');

        return $attempt->package->questions()
            ->with(['options', 'category'])
            ->orderBy('order_number')
            ->get()
            ->map(function ($question) use ($userAnswers) {
                $userAnswer = $userAnswers->get($question->id);

                return [
                    'id' => $question->id,
                    'number' => $question->order_number,
                    'category' => $question->category->code ?? 'N/A',
                    'category_name' => $question->category->name ?? 'N/A',
                    'question_text' => $question->question_text,
                    'question_image' => $question->question_image,
                    'options' => $question->options->map(fn($opt) => [
                        'id' => $opt->id,
                        'label' => $opt->label,
                        'text' => $opt->option_text,
                    ])->toArray(), // Explicitly convert to array
                    'selected_option_id' => $userAnswer?->selected_option_id,
                    'is_bookmarked' => $userAnswer?->is_bookmarked ?? false,
                ];
            });
    }

    /**
     * Get question navigation data.
     */
    public function getNavigationData(TestAttempt $attempt): array
    {
        $questions = $attempt->package->questions()
            ->with('category')
            ->orderBy('order_number')
            ->get();
            
        $answers = $attempt->userAnswers->keyBy('question_id');

        $categories = [];
        foreach ($questions as $question) {
            $code = $question->category->code ?? 'OTHER';
            if (!isset($categories[$code])) {
                $categories[$code] = [
                    'code' => $code,
                    'name' => $question->category->name ?? 'Other',
                    'questions' => [],
                ];
            }
            
            $answer = $answers->get($question->id);
            
            $categories[$code]['questions'][] = [
                'number' => $question->order_number,
                'question_id' => $question->id,
                'is_answered' => !is_null($answer?->selected_option_id),
                'is_bookmarked' => $answer?->is_bookmarked ?? false,
            ];
        }

        return [
            'categories' => array_values($categories),
            'total_questions' => $questions->count(),
            'answered_count' => $answers->whereNotNull('selected_option_id')->count(),
            'bookmarked_count' => $answers->where('is_bookmarked', true)->count(),
        ];
    }

    /**
     * Submit an answer for a question.
     */
    public function submitAnswer(TestAttempt $attempt, int $questionId, int $optionId, int $timeSpent = 0): UserAnswer
    {
        if (!$attempt->isInProgress()) {
            throw new Exception('Test is not in progress');
        }

        if ($attempt->hasTimeExpired()) {
            $this->autoSubmit($attempt);
            throw new Exception('Time has expired');
        }

        $answer = $attempt->userAnswers()
            ->firstOrCreate(['question_id' => $questionId]);

        $answer->update([
            'selected_option_id' => $optionId,
            'time_spent_seconds' => $answer->time_spent_seconds + $timeSpent,
        ]);

        // Calculate points
        $answer->calculatePoints();

        // Log activity
        ActivityLog::log(ActivityLog::ACTION_ANSWER_SUBMIT, $attempt->user_id, $attempt->id, [
            'question_id' => $questionId,
            'option_id' => $optionId,
        ]);

        return $answer->fresh();
    }

    /**
     * Toggle bookmark for a question.
     */
    public function toggleBookmark(TestAttempt $attempt, int $questionId): bool
    {
        $answer = $attempt->userAnswers()
            ->firstOrCreate(['question_id' => $questionId]);

        return $answer->toggleBookmark();
    }

    /**
     * Submit the test.
     */
    public function submitTest(TestAttempt $attempt): TestAttempt
    {
        if (!$attempt->isInProgress()) {
            throw new Exception('Test is already completed');
        }

        // Calculate all answer points
        foreach ($attempt->userAnswers as $answer) {
            if ($answer->selected_option_id && !$answer->points_earned) {
                $answer->calculatePoints();
            }
        }

        // Complete the test
        $attempt->complete();

        // Log activity
        ActivityLog::log(ActivityLog::ACTION_TEST_SUBMIT, $attempt->user_id, $attempt->id, [
            'total_score' => $attempt->total_score,
            'passed' => $attempt->passed_overall,
        ]);

        return $attempt->fresh();
    }

    /**
     * Auto-submit when time expires.
     */
    public function autoSubmit(TestAttempt $attempt): TestAttempt
    {
        $attempt->update(['status' => TestAttempt::STATUS_TIMEOUT]);
        return $this->submitTest($attempt);
    }

    /**
     * Get test result.
     */
    public function getResult(TestAttempt $attempt): array
    {
        return [
            'id' => $attempt->id,
            'package' => $attempt->package->name,
            'started_at' => $attempt->started_at->format('d M Y H:i'),
            'finished_at' => $attempt->finished_at?->format('d M Y H:i'),
            'duration_minutes' => $attempt->started_at && $attempt->finished_at 
                ? $attempt->started_at->diffInMinutes($attempt->finished_at) 
                : null,
            'scores' => [
                'twk' => [
                    'score' => $attempt->score_twk,
                    'passing_grade' => TestAttempt::PASSING_GRADE_TWK,
                    'max_score' => 150,
                    'passed' => $attempt->passed_twk,
                ],
                'tiu' => [
                    'score' => $attempt->score_tiu,
                    'passing_grade' => TestAttempt::PASSING_GRADE_TIU,
                    'max_score' => 175,
                    'passed' => $attempt->passed_tiu,
                ],
                'tkp' => [
                    'score' => $attempt->score_tkp,
                    'passing_grade' => TestAttempt::PASSING_GRADE_TKP,
                    'max_score' => 225,
                    'passed' => $attempt->passed_tkp,
                ],
            ],
            'total_score' => $attempt->total_score,
            'max_total_score' => 550,
            'passed_overall' => $attempt->passed_overall,
            'tab_switch_count' => $attempt->tab_switch_count,
            'status' => $attempt->status,
        ];
    }

    public function getReviewData(TestAttempt $attempt): Collection
    {
        return $attempt->userAnswers()
            ->with(['question.options', 'question.category', 'selectedOption'])
            ->get()
            ->map(function ($answer) {
                $question = $answer->question;
                $categoryCode = $question->category->code ?? '';

                // For TWK/TIU, determine the correct option ID if not set
                $correctOptionId = $question->correct_option_id;
                if (!$correctOptionId && $categoryCode !== 'TKP') {
                    $correctOption = $question->options->where('is_correct', true)->first();
                    $correctOptionId = $correctOption ? $correctOption->id : null;
                }

                return [
                    'number' => $question->order_number,
                    'category' => $categoryCode,
                    'question_text' => $question->question_text,
                    'question_image' => $question->question_image,
                    'options' => $question->options->map(fn($opt) => [
                        'id' => $opt->id,
                        'label' => $opt->label,
                        'text' => $opt->option_text,
                        'is_correct' => $categoryCode === 'TKP' ? $opt->points === 5 : $opt->is_correct,
                        'points' => $opt->points,
                    ]),
                    'selected_option_id' => $answer->selected_option_id,
                    'correct_option_id' => $correctOptionId,
                    'is_correct' => $answer->is_correct,
                    'points_earned' => $answer->points_earned,
                    'explanation' => $question->explanation,
                ];
            });
    }

    /**
     * Record tab switch activity.
     */
    public function recordTabSwitch(TestAttempt $attempt): int
    {
        $attempt->incrementTabSwitchCount();

        ActivityLog::log(ActivityLog::ACTION_TAB_SWITCH, $attempt->user_id, $attempt->id, [
            'count' => $attempt->tab_switch_count,
        ]);

        return $attempt->tab_switch_count;
    }
}
