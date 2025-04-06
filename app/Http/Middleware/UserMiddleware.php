<?php

namespace App\Http\Middleware;

use App\Models\Quiz;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if (empty($user->power)) {
                $entranceQuiz = Quiz::where('is_entrance_quiz', true)->inRandomOrder()->first();

                if ($entranceQuiz) {
                    $currentQuiz = $request->route('quiz');
                    
                    // Only redirect if not already viewing the entrance exam
                    if (!$currentQuiz || $currentQuiz->id !== $entranceQuiz->id) {
                        return redirect()->route('user.quizzes.entrance', $entranceQuiz);
                    }
                }
            }
        }

        return $next($request);
    }
}
