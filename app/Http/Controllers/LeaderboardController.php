<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // Get all quizzes for the filter dropdown
        $quizzes = Quiz::all();

        // Base query for user results
        $query = User::whereNot('role', 'admin')->select('users.id', 'users.name', 'users.power', 'users.exp',
            DB::raw('COUNT(quiz_results.id) as quizzes_taken'),
            DB::raw('MAX(typing_tests.wpm) as best_wpm'),
            DB::raw('AVG(typing_tests.wpm) as avg_wpm'),
            DB::raw('COUNT(typing_tests.id) as typing_tests_taken'))
            ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->leftJoin('typing_tests', 'users.id', '=', 'typing_tests.user_id')
            ->groupBy('users.id', 'users.name', 'users.power', 'users.exp');

        // Apply filters
        if ($request->filled('quiz_id')) {
            $query->where('quiz_results.quiz_id', $request->quiz_id);
        }

        if ($request->filled('element')) {
            $query->where('users.power', $request->element);
        }

        if ($request->filled('time_period')) {
            $timePeriod = $request->time_period;

            if ($timePeriod === 'this_week') {
                $query->where(function($q) {
                    $q->whereBetween('quiz_results.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                      ->orWhereBetween('typing_tests.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                });
            } elseif ($timePeriod === 'this_month') {
                $query->where(function($q) {
                    $q->where(function($inner) {
                        $inner->whereMonth('quiz_results.created_at', now()->month)
                              ->whereYear('quiz_results.created_at', now()->year);
                    })->orWhere(function($inner) {
                        $inner->whereMonth('typing_tests.created_at', now()->month)
                              ->whereYear('typing_tests.created_at', now()->year);
                    });
                });
            }
        }

        // Get all users for the main leaderboard 
        $allUsers = (clone $query)
            ->orderBy('users.exp', 'DESC')
            ->get();

        // Get users by element
        $airUsers = (clone $query)
            ->where('users.power', 'air')
            ->orderBy('users.exp', 'DESC')
            ->get();

        $fireUsers = (clone $query)
            ->where('users.power', 'fire')
            ->orderBy('users.exp', 'DESC')
            ->get();

        $waterUsers = (clone $query)
            ->where('users.power', 'water')
            ->orderBy('users.exp', 'DESC')
            ->get();

        $earthUsers = (clone $query)
            ->where('users.power', 'earth')
            ->orderBy('users.exp', 'DESC')
            ->get();

        // Get top typing test performers
        $typingLeaders = User::whereNot('role', 'admin')
            ->select('users.id', 'users.name', 'users.power', 
                DB::raw('MAX(typing_tests.wpm) as best_wpm'),
                DB::raw('AVG(typing_tests.wpm) as avg_wpm'),
                DB::raw('COUNT(typing_tests.id) as typing_tests_taken'))
            ->leftJoin('typing_tests', 'users.id', '=', 'typing_tests.user_id')
            ->groupBy('users.id', 'users.name', 'users.power')
            ->having('typing_tests_taken', '>', 0)
            ->orderBy('best_wpm', 'DESC')
            ->get();

        return view('user.leaderboard', compact(
            'quizzes', 
            'allUsers', 
            'airUsers', 
            'fireUsers', 
            'waterUsers', 
            'earthUsers',
            'typingLeaders'
        ));
    }
}
