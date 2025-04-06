<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\UserResultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);

    // Quiz Routes
    Route::resource('quizzes', QuizController::class);

    // Question Routes
    Route::get('quizzes/{quiz}/questions', [QuestionController::class, 'index'])->name('quizzes.questions.index');
    Route::get('quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('quizzes.questions.create');
    Route::get('quizzes/{quiz}/questions/generate', [QuestionController::class, 'generate'])->name('quizzes.questions.generate');
    Route::post('quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('quizzes.questions.store');
    Route::post('quizzes/{quiz}/questions/generate', [QuestionController::class, 'storeGenerated'])->name('quizzes.questions.storeGenerated');
    Route::resource('questions', QuestionController::class)->except(['index', 'create', 'store']);

    // Answer Routes
    Route::get('questions/{question}/answers/create', [AnswerController::class, 'create'])->name('questions.answers.create');
    Route::post('questions/{question}/answers', [AnswerController::class, 'store'])->name('questions.answers.store');
    Route::resource('answers', AnswerController::class)->except(['index', 'create', 'store']);

    // Result Routes
    Route::resource('results', ResultController::class)->except(['create', 'store', 'edit', 'update']);
});

Route::middleware(['auth', 'role:user', 'power'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('password.update');
    
    // Quizzes
    Route::get('/quizzes', [UserQuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/random', [UserQuizController::class, 'random'])->name('quizzes.random');
    Route::get('/quizzes/{quiz}', [UserQuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/take', [UserQuizController::class, 'take'])->name('quizzes.take');
    Route::post('/quizzes/{quiz}/submit', [UserQuizController::class, 'submit'])->name('quizzes.submit');
    
    // Results
    Route::get('/results', [UserResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result}', [UserResultController::class, 'show'])->name('results.show');
    
    // Leaderboard
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
});

Route::middleware(['auth', 'role:user', 'no_power'])->prefix('user')->name('user.')->group(function () {
    Route::get('/quiz/{quiz}/entrance', [UserQuizController::class, 'entrance'])->name('quizzes.entrance');
    Route::post('/quizzes/{quiz}/entrance/submit', [UserQuizController::class, 'submit'])->name('quizzes.entrance.submit');
});

require __DIR__ . '/auth.php';
