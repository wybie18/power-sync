<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypingTest extends Model
{
    protected $fillable = [
        'user_id',
        'wpm',
        'accuracy',
        'exp_earned',
        'errors_count',
        'time_taken_seconds'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
