@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $quiz->title }}</h1>
        <p class="text-gray-600 dark:text-gray-400">{{ $quiz->description }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Quiz Information</h2>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <p class="text-gray-600 dark:text-gray-400">This quiz contains {{ $quiz->questions->count() }} questions.
                    Your answers will increase or decrease your experience based on your choices. Choose wisely to build your character's strength!</p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('user.quizzes.index') }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                    Back to Quizzes
                </a>
                <a href="{{ route('user.quizzes.take', $quiz) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Start Quiz
                </a>
            </div>
        </div>
    </div>
@endsection
