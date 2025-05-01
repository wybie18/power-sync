@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">My Results</h1>
        <p class="text-gray-600 dark:text-gray-400">View your quiz and typing test history and performance</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
        <div class="p-4 border-b dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">Filter Results</h2>
        </div>
        <div class="p-4">
            <form action="{{ route('user.results.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="quiz_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quiz</label>
                    <select name="quiz_id" id="quiz_id"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Quizzes</option>
                        @foreach ($quizzes as $quiz)
                            <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                {{ $quiz->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="date_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date
                        Range</label>
                    <select name="date_range" id="date_range"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Time</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Filter
                    </button>
                    @if (request()->hasAny(['quiz_id', 'element', 'date_range']))
                        <a href="{{ route('user.results.index') }}"
                            class="ml-2 px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Results Tabs -->
    <div x-data="{ activeTab: 'quizzes' }" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="border-b dark:border-gray-700">
            <nav class="flex -mb-px">
                <button @click="activeTab = 'quizzes'"
                    :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'quizzes', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'quizzes' }"
                    class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                    Quiz Results
                </button>
                <button @click="activeTab = 'typing'"
                    :class="{ 'border-purple-500 text-purple-600 dark:text-purple-400': activeTab === 'typing', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'typing' }"
                    class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                    Typing Tests
                </button>
            </nav>
        </div>

        <!-- Quiz Results Tab -->
        <div x-show="activeTab === 'quizzes'">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Quiz Results ({{ $results->total() }})</h2>
            </div>

            @if ($results->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Quiz</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Score</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($results as $result)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $result->quiz->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $result->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $result->total_score }} / {{ $result->max_possible_score }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <a href="{{ route('user.results.show', $result) }}"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4">
                    {{ $results->withQueryString()->links() }}
                </div>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't taken any quizzes yet.</p>
                    <a href="{{ route('user.quizzes.index') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Take Your First Quiz
                    </a>
                </div>
            @endif
        </div>

        <!-- Typing Test Results Tab -->
        <div x-show="activeTab === 'typing'">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Typing Test Results 
                    ({{ isset($typingResults) ? $typingResults->total() : 0 }})</h2>
            </div>

            <!-- Typing Stats Summary -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 border-b dark:border-gray-700">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tests Taken</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $typingStats->total_tests ?? 0 }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Best WPM</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ round($typingStats->best_wpm ?? 0) }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Average WPM</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ round($typingStats->avg_wpm ?? 0) }}</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Best Accuracy</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ round($typingStats->best_accuracy ?? 0) }}%</p>
                </div>
            </div>

            @if (isset($typingResults) && $typingResults->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    WPM</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Accuracy</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Time (seconds)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($typingResults as $test)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $test->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ round($test->wpm) }} WPM
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ round($test->accuracy) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $test->time_taken_seconds }}s
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4">
                    {{ $typingResults->withQueryString()->links() }}
                </div>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't taken any typing tests yet.</p>
                    <a href="{{ route('typing.test.index') }}"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Take Your First Typing Test
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection