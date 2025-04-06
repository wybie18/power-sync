@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Quiz Results</h1>
        <p class="text-gray-600 dark:text-gray-400">Your results for "{{ $result->quiz->title }}"</p>
    </div>

    <!-- Results Summary -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
        <div class="p-6 border-b dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Your Alignment</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-col items-center">
                <div
                    class="w-32 h-32 rounded-full flex items-center justify-center mb-4 {{ $result->alignment === 'hero' ? 'bg-blue-100 dark:bg-blue-900' : 'bg-red-100 dark:bg-red-900' }}">
                    <span
                        class="text-5xl {{ $result->alignment === 'hero' ? 'text-blue-600 dark:text-blue-300' : 'text-red-600 dark:text-red-300' }}">
                        @if ($result->alignment === 'hero')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        @endif
                    </span>
                </div>
                <h3
                    class="text-2xl font-bold {{ $result->alignment === 'hero' ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }} mb-2">
                    You are a {{ ucfirst($result->alignment) }}!
                </h3>
                <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                    @if ($result->alignment === 'hero')
                        Your answers show that you have heroic tendencies. You prioritize helping others and doing what's
                        right, even when it's difficult.
                    @else
                        Your answers reveal villainous tendencies. You're not afraid to break the rules and put your own
                        interests first.
                    @endif
                </p>

                <div class="w-full max-w-md">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Score</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $result->total_score }} /
                            {{ $result->max_possible_score }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                        <div class="bg-indigo-600 h-2.5 rounded-full"
                            style="width: {{ ($result->total_score / $result->max_possible_score) * 100 }}%"></div>
                    </div>

                    <div class="relative pt-1 mb-6">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span
                                    class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200 dark:text-red-200 dark:bg-red-900">
                                    Villain
                                </span>
                            </div>
                            <div>
                                <span
                                    class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 dark:text-blue-200 dark:bg-blue-900">
                                    Hero
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200 dark:bg-gray-700">
                            @php
                                $heroPercentage =
                                    $result->total_score > 0
                                        ? min(
                                            100,
                                            max(
                                                0,
                                                50 + ($result->total_score / max(abs($result->total_score), 20)) * 50,
                                            ),
                                        )
                                        : max(
                                            0,
                                            50 - (abs($result->total_score) / max(abs($result->total_score), 20)) * 50,
                                        );
                            @endphp
                            <div style="width: {{ $heroPercentage }}%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                            </div>
                            <div style="width: {{ 100 - $heroPercentage }}%"
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('user.quizzes.index') }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Take Another Quiz
                    </a>
                    <a href="{{ route('user.leaderboard') }}"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        View Leaderboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Answer Details -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Your Answers</h2>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                @foreach ($result->answers as $index => $answer)
                    <div class="border dark:border-gray-700 rounded-lg p-4">
                        <h3 class="font-medium text-gray-800 dark:text-white mb-2">{{ $answer->question->question }}</h3>
                        <div
                            class="pl-4 border-l-2 {{ $answer->score > 0 ? 'border-blue-500 dark:border-blue-400' : 'border-red-500 dark:border-red-400' }}">
                            <p class="text-gray-700 dark:text-gray-300">{{ $answer->answer }}</p>
                            <p
                                class="text-sm mt-1 {{ $answer->score > 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }}">
                                Score: {{ $answer->score }} ({{ $answer->score > 0 ? 'Hero' : 'Villain' }})
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
