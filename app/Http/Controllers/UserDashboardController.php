<?php
namespace App\Http\Controllers;

use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get user statistics
        $userStats = $this->getUserStats();

        // Get recent results
        $recentResults = QuizResult::with('quiz')
            ->where('user_id', $user->id)
            ->whereHas('quiz', function ($query) {
                $query->where('is_entrance_quiz', false);
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('user.dashboard', compact('userStats', 'recentResults'));
    }

    private function getUserStats()
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
