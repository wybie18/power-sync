<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultAnswer extends Model
{
    protected $fillable = [
        'quiz_result_id',
        'question_id',
        'answer_id',
        'answer',
        'score',
    ];

    public function quizResult()
    {
        return $this->belongsTo(QuizResult::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
