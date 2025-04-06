<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;

class DashboardController extends Controller
{
/**
 * Display the admin dashboard.
 */
    public function index()
    {
        $totalUsers   = User::count();
        $totalQuizzes = Quiz::count();
        $quizzesTaken = QuizResult::count();

        // Get counts for each element
        $airCount    = QuizResult::where('element', 'air')->count();
        $earthCount  = QuizResult::where('element', 'earth')->count();
        $fireCount   = QuizResult::where('element', 'fire')->count();
        $waterCount  = QuizResult::where('element', 'water')->count();

        // Calculate percentages for each element
        $airPercentage    = $quizzesTaken > 0 ? round(($airCount / $quizzesTaken) * 100) : 0;
        $earthPercentage  = $quizzesTaken > 0 ? round(($earthCount / $quizzesTaken) * 100) : 0;
        $firePercentage   = $quizzesTaken > 0 ? round(($fireCount / $quizzesTaken) * 100) : 0;
        $waterPercentage  = $quizzesTaken > 0 ? round(($waterCount / $quizzesTaken) * 100) : 0;

        $recentResults = QuizResult::with(['user', 'quiz'])
            ->latest()
            ->take(5)
            ->get();

        $newUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalQuizzes',
            'quizzesTaken',
            'airCount',
            'earthCount',
            'fireCount',
            'waterCount',
            'airPercentage',
            'earthPercentage',
            'firePercentage',
            'waterPercentage',
            'recentResults',
            'newUsers'
        ));
    }
}
