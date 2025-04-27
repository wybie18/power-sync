<?php
namespace App\Http\Controllers;

use App\Models\TypingTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypingTestController extends Controller
{
    public function index()
    {
        $exp      = Auth::user()->exp ?? 0;
        $level     = (int) floor(sqrt($exp / 100)) + 1;
        $paragraph = fake()->paragraph(4 + $level);
        return view('user.typing.index', compact('paragraph', 'level'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wpm'                => 'required|integer|min:1',
            'accuracy'           => 'required|numeric|min:0|max:100',
            'errors_count'       => 'required|integer|min:0',
            'time_taken_seconds' => 'required|integer|min:1',
        ]);
        $user                 = Auth::user();
        $exp                  = $user->exp ?? 0;
        $level                = (int) floor(sqrt($exp / 100)) + 1;
        $baseExp              = 20;
        $difficultyMultiplier = $level * 0.5 + 0.5;
        $wpmFactor            = min($validated['wpm'] / 50, 2.0);
        $accuracyFactor       = ($validated['accuracy'] / 100) * 2;
        $performanceFactor    = ($wpmFactor + $accuracyFactor) / 2;
        $expEarned            = round($baseExp * $performanceFactor);

        TypingTest::create([
            'user_id'    => Auth::id(),
            'exp_earned' => $expEarned,
            ...$validated,
        ]);

        $user->increment('exp', $expEarned);

        return redirect()->route('user.typing.test.index')->with('success', 'Challenge completed successfully!');
    }
}
