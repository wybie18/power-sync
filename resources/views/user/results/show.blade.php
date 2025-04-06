@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Quiz Results</h1>
        <p class="text-gray-600 dark:text-gray-400">Your results for "{{ $result->quiz->title }}"</p>
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
                            class="pl-4 border-l-2 
                            @if ($answer->element === 'air') border-blue-500 dark:border-blue-400
                            @elseif($answer->element === 'fire')
                                border-red-500 dark:border-red-400
                            @elseif($answer->element === 'water')
                                border-cyan-500 dark:border-cyan-400
                            @elseif($answer->element === 'earth')
                                border-green-500 dark:border-green-400
                            @else
                                border-gray-500 dark:border-gray-400 @endif">
                            <p class="text-gray-700 dark:text-gray-300">{{ $answer->answer }}</p>
                            <div class="flex items-center mt-1">
                                <p
                                    class="text-sm 
                                    @if ($answer->element === 'air') text-blue-600 dark:text-blue-400
                                    @elseif($answer->element === 'fire')
                                        text-red-600 dark:text-red-400
                                    @elseif($answer->element === 'water')
                                        text-cyan-600 dark:text-cyan-400
                                    @elseif($answer->element === 'earth')
                                        text-green-600 dark:text-green-400
                                    @else
                                        text-gray-600 dark:text-gray-400 @endif">
                                    Score: {{ $answer->score }}
                                </p>
                                @if ($answer->element)
                                    <span
                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if ($answer->element === 'air') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($answer->element === 'fire')
                                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($answer->element === 'water')
                                            bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200
                                        @elseif($answer->element === 'earth')
                                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                        {{ ucfirst($answer->element) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('user.results.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">&larr;
            Back to Results</a>
    </div>
@endsection
