<?php
namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource for a specific quiz.
     */
    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions()->with('answers')->get();

        return view('admin.quizzes.questions.index', compact('quiz', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Quiz $quiz)
    {
        return view('admin.quizzes.questions.create', compact('quiz'));
    }

    public function generate(Request $request, Quiz $quiz)
    {
        $amount   = $request->input('amount', 10);
        $category = $request->input('category', 31);
        $type     = 'multiple';

        $response = Http::get("https://opentdb.com/api.php", [
            'amount'   => $amount,
            'category' => $category,
            'type'     => $type,
        ]);

        if (! $response->successful() || $response->json('response_code') !== 0) {
            return back()->withErrors('Failed to fetch questions from the API');
        }

        $questions = collect($response->json('results'))->map(function ($question) {
            return [
                'category'          => $question['category'],
                'type'              => $question['type'],
                'difficulty'        => $question['difficulty'],
                'question'          => html_entity_decode($question['question'], ENT_QUOTES | ENT_HTML5),
                'correct_answer'    => html_entity_decode($question['correct_answer'], ENT_QUOTES | ENT_HTML5),
                'incorrect_answers' => collect($question['incorrect_answers'])
                    ->map(fn($answer) => html_entity_decode($answer, ENT_QUOTES | ENT_HTML5))
                    ->toArray(),
            ];
        })->toArray();

        return view('admin.quizzes.questions.generate', compact('quiz', 'questions'));
    }

    public function storeGenerated(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'questions'                    => 'required|array',
            'questions.*.question'         => 'required|string',
            'questions.*.answers'          => 'required|array|min:2',
            'questions.*.answers.*.answer' => 'required|string',
            'questions.*.answers.*.score'  => 'required|integer',
        ]);

        foreach ($validated['questions'] as $questionData) {
            $question = $quiz->questions()->create([
                'question' => $questionData['question'],
            ]);

            foreach ($questionData['answers'] as $answer) {
                $question->answers()->create([
                    'answer' => $answer['answer'],
                    'score'  => $answer['score'],
                ]);
            }
        }

        return redirect()->route('admin.quizzes.show', $quiz)
            ->with('success', 'Quiz questions saved successfully!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question'         => 'required|string|max:255',
            'answers'          => 'required|array|min:2',
            'answers.*.answer' => 'required|string|max:255',
            'answers.*.score'  => 'required|integer',
        ]);

        $question = $quiz->questions()->create([
            'question' => $validated['question'],
        ]);

        foreach ($validated['answers'] as $answerData) {
            $question->answers()->create([
                'answer' => $answerData['answer'],
                'score'  => $answerData['score'],
            ]);
        }

        return redirect()->route('admin.quizzes.questions.index', $quiz)
            ->with('success', 'Question added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $question->load('answers');

        return view('admin.quizzes.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question->update($validated);

        return redirect()->route('admin.quizzes.questions.index', $question->quiz_id)
            ->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $quizId = $question->quiz_id;
        $question->delete();

        return redirect()->route('admin.quizzes.questions.index', $quizId)
            ->with('success', 'Question deleted successfully');
    }
}
