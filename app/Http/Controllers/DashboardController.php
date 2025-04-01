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

        $heroCount    = QuizResult::where('alignment', 'hero')->count();
        $villainCount = QuizResult::where('alignment', 'villain')->count();

        $heroPercentage    = $quizzesTaken > 0 ? round(($heroCount / $quizzesTaken) * 100) : 0;
        $villainPercentage = $quizzesTaken > 0 ? round(($villainCount / $quizzesTaken) * 100) : 0;

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
            'heroPercentage',
            'villainPercentage',
            'recentResults',
            'newUsers'
        ));
    }
}
