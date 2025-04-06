<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserResultController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
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

        return view('user.results.index', compact('results', 'quizzes'));
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
        
        return $stats;
    }
}
