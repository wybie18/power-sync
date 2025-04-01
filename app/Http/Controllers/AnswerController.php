<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Question $question)
    {
        return view('admin.questions.answers.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Question $question)
    {
        $validated = $request->validate([
            'answer' => 'required|string|max:255',
            'score' => 'required|integer',
        ]);

        $question->answers()->create($validated);

        return redirect()->route('admin.quizzes.questions.index', $question->quiz_id)
            ->with('success', 'Answer added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        return view('admin.answers.edit', compact('answer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        $validated = $request->validate([
            'answer' => 'required|string|max:255',
            'score' => 'required|integer',
        ]);

        $answer->update($validated);

        $question = $answer->question;
        
        return redirect()->route('admin.quizzes.questions.index', $question->quiz_id)
            ->with('success', 'Answer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        $question = $answer->question;
        $answer->delete();

        return redirect()->route('admin.quizzes.questions.index', $question->quiz_id)
            ->with('success', 'Answer deleted successfully');
    }
}
