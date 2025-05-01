<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\TypingTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserResultController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = QuizResult::with('quiz')->where('user_id', $user->id);

        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        if ($request->filled('alignment')) {
            $query->where('alignment', $request->alignment);
        }

        if ($request->filled('date_range')) {
            $dateRange = $request->date_range;

            if ($dateRange === 'today') {
                $query->whereDate('created_at', today());
            } elseif ($dateRange === 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($dateRange === 'month') {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }
        }

        $results = $query->orderBy('created_at', 'desc')->paginate(10);
        $quizzes = Quiz::all();

        // Get typing test results 
        $typingQuery = TypingTest::where('user_id', $user->id);

        if ($request->filled('date_range')) {
            $dateRange = $request->date_range;

            if ($dateRange === 'today') {
                $typingQuery->whereDate('created_at', today());
            } elseif ($dateRange === 'week') {
                $typingQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($dateRange === 'month') {
                $typingQuery->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }
        }

        $typingResults = $typingQuery->orderBy('created_at', 'desc')->paginate(10);

        // Get stats for typing tests
        $typingStats = $this->getTypingStats($user->id);

        return view('user.results.index', compact('results', 'quizzes', 'typingResults', 'typingStats'));
    }

    public function show(QuizResult $result)
    {
        if ($result->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $result->load(['quiz', 'answers.question']);

        return view('user.results.show', compact('result'));
    }

    public function getUserStats()
    {
        $user = Auth::user();
        $results = QuizResult::where('user_id', $user->id)->get();
        
        $stats = new \stdClass();
        $stats->quizzes_taken = $results->count();
        $stats->total_score = $results->sum('total_score');
        $stats->alignment = $stats->total_score >= 0 ? 'hero' : 'villain';
        
        // Add typing test stats
        $typingStats = $this->getTypingStats($user->id);
        $stats->typing_tests_taken = $typingStats->total_tests;
        $stats->best_wpm = $typingStats->best_wpm;
        $stats->avg_wpm = $typingStats->avg_wpm;
        
        return $stats;
    }

    private function getTypingStats($userId)
    {
        $tests = TypingTest::where('user_id', $userId)->get();
        
        $stats = new \stdClass();
        $stats->total_tests = $tests->count();
        $stats->best_wpm = $tests->max('wpm') ?? 0;
        $stats->avg_wpm = $tests->avg('wpm') ?? 0;
        $stats->best_accuracy = $tests->max('accuracy') ?? 0;
        $stats->avg_accuracy = $tests->avg('accuracy') ?? 0;
        
        return $stats;
    }
}