<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $quizId     = $request->input('quiz_id');
        $element    = $request->input('element');
        $userSearch = $request->input('user');

        $results = QuizResult::with(['user', 'quiz'])
            ->when($quizId, function ($query) use ($quizId) {
                $query->where('quiz_id', $quizId);
            })
            ->when($element, function ($query) use ($element) {
                $query->where('element', $element);
            })
            ->when($userSearch, function ($query) use ($userSearch) {
                $query->whereHas('user', function ($q) use ($userSearch) {
                    $q->where('name', 'like', "%{$userSearch}%")
                        ->orWhere('email', 'like', "%{$userSearch}%");
                });
            })
            ->latest()
            ->paginate(15);

        $quizzes = Quiz::all();

        $totalResults = QuizResult::count();
        $averageScore = QuizResult::avg('total_score');
        
        // Get counts for each element
        $airCount    = QuizResult::where('element', 'air')->count();
        $earthCount  = QuizResult::where('element', 'earth')->count();
        $fireCount   = QuizResult::where('element', 'fire')->count();
        $waterCount  = QuizResult::where('element', 'water')->count();

        // Data for quiz popularity chart
        $quizPopularity = QuizResult::select('quiz_id', DB::raw('count(*) as total'))
            ->groupBy('quiz_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $quizPopularityLabels = $quizPopularity->map(function ($item) {
            return Quiz::find($item->quiz_id)->title;
        });

        $quizPopularityData = $quizPopularity->pluck('total');

        // Element distribution data for charts
        $elementData = [
            'air' => $airCount,
            'earth' => $earthCount,
            'fire' => $fireCount,
            'water' => $waterCount
        ];

        return view('admin.results.index', compact(
            'results',
            'quizzes',
            'totalResults',
            'averageScore',
            'airCount',
            'earthCount',
            'fireCount',
            'waterCount',
            'quizPopularityLabels',
            'quizPopularityData'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizResult $result)
    {
        $result->load(['user', 'quiz.questions.answers']);

        return view('admin.results.show', compact('result'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizResult $result)
    {
        $result->delete();

        return redirect()->route('admin.results.index')
            ->with('success', 'Result deleted successfully');
    }
}
