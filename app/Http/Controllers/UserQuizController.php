<?php
namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserQuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::withCount('questions')
            ->withCount('results');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $quizzes = $query->orderBy('title')->paginate(9);

        return view('user.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('questions.answers');

        return view('user.quizzes.show', compact('quiz'));
    }

    public function random()
    {
        $quiz = Quiz::inRandomOrder()->first();

        if (! $quiz) {
            return redirect()->route('user.quizzes.index')
                ->with('error', 'No quizzes available.');
        }

        return redirect()->route('user.quizzes.show', $quiz);
    }

    public function take(Quiz $quiz)
    {
        $quiz->load(['questions' => function ($query) {
            $query->inRandomOrder()->with(['answers' => function ($q) {
                $q->inRandomOrder();
            }]);
        }]);

        return view('user.quizzes.create', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers'   => 'required|array',
            'answers.*' => 'required|exists:answers,id',
        ]);

        $user             = Auth::user();
        $elements         = ['fire' => 0, 'water' => 0, 'air' => 0, 'earth' => 0];
        $totalScore       = 0;
        $maxPossibleScore = 0;

        DB::beginTransaction();

        try {
            $quizResult = QuizResult::create([
                'user_id'            => $user->id,
                'quiz_id'            => $quiz->id,
                'total_score'        => 0,
                'max_possible_score' => 0,
                'element'            => null,
            ]);

            foreach ($validated['answers'] as $questionId => $answerId) {
                $question = Question::findOrFail($questionId);
                $answer   = Answer::findOrFail($answerId);

                if ($answer->question_id != $questionId) {
                    throw new \Exception('Invalid answer for question.');
                }

                if($answer->element){
                    $elements[$answer->element] += $answer->score;
                }
                $totalScore += $answer->score;

                $maxQuestionScore = $question->answers->max('score');
                $maxPossibleScore += $maxQuestionScore;

                $quizResult->answers()->create([
                    'question_id' => $questionId,
                    'answer_id'   => $answerId,
                    'answer'      => $answer->answer,
                    'score'       => $answer->score,
                    'element'     => $answer->element,
                ]);
            }

            arsort($elements);
            $dominantElement = array_key_first($elements);

            $quizResult->update([
                'total_score'        => $totalScore,
                'max_possible_score' => $maxPossibleScore,
                'element'            => $dominantElement,
            ]);

            $user->increment('exp', $totalScore);

            if ($quiz->is_entrance_quiz && empty($user->power)) {
                $user->update(['power' => $dominantElement]);
            }

            DB::commit();

            return redirect()->route('user.results.show', $quizResult)
                ->with('success', 'Quiz completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('user.quizzes.take', $quiz)
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function entrance(Quiz $quiz)
    {
        $quiz->load(['questions' => function ($query) {
            $query->inRandomOrder()->with(['answers' => function ($q) {
                $q->inRandomOrder();
            }]);
        }]);

        return view('user.entrance', compact('quiz'));
    }
}
