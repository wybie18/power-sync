@extends('layouts.admin-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Quiz Results</h1>
        <p class="text-gray-600 dark:text-gray-400">View and analyze quiz results</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Results Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Results</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalResults }}</p>
                </div>
            </div>
        </div>

        <!-- Average Score Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Average Score</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $averageScore }}</p>
                </div>
            </div>
        </div>

        <!-- Hero Count Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Heroes</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $heroCount }} ({{ $heroPercentage }}%)</p>
                </div>
            </div>
        </div>

        <!-- Villain Count Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 mr-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Villains</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $villainCount }} ({{ $villainPercentage }}%)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Alignment Distribution Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Alignment Distribution</h2>
            <div class="h-64">
                <canvas id="alignmentChart"></canvas>
            </div>
        </div>

        <!-- Quiz Popularity Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quiz Popularity</h2>
            <div class="h-64">
                <canvas id="quizPopularityChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b dark:border-gray-700">
            <form action="{{ route('admin.results.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="quiz_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Quiz</label>
                    <select name="quiz_id" id="quiz_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">All Quizzes</option>
                        @foreach($quizzes as $quiz)
                            <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>{{ $quiz->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="alignment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Alignment</label>
                    <select name="alignment" id="alignment" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">All Alignments</option>
                        <option value="hero" {{ request('alignment') == 'hero' ? 'selected' : '' }}>Hero</option>
                        <option value="villain" {{ request('alignment') == 'villain' ? 'selected' : '' }}>Villain</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label for="user" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search by User</label>
                    <input type="text" name="user" id="user" value="{{ request('user') }}" placeholder="Search by user name or email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quiz</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alignment</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($results as $result)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $result->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $result->quiz->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $result->total_score }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $result->alignment === 'hero' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ ucfirst($result->alignment) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $result->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.results.show', $result) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $results->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alignment Distribution Chart
            const alignmentCtx  function() {
            // Alignment Distribution Chart
            const alignmentCtx = document.getElementById('alignmentChart').getContext('2d');
            new Chart(alignmentCtx, {
                type: 'pie',
                data: {
                    labels: ['Hero', 'Villain'],
                    datasets: [{
                        data: [{{ $heroCount }}, {{ $villainCount }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: document.querySelector('html').classList.contains('dark') ? 'white' : 'black'
                            }
                        }
                    }
                }
            });

            // Quiz Popularity Chart
            const quizPopularityCtx = document.getElementById('quizPopularityChart').getContext('2d');
            new Chart(quizPopularityCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($quizPopularityLabels) !!},
                    datasets: [{
                        label: 'Number of Attempts',
                        data: {!! json_encode($quizPopularityData) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: document.querySelector('html').classList.contains('dark') ? 'white' : 'black'
                            },
                            grid: {
                                color: document.querySelector('html').classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: document.querySelector('html').classList.contains('dark') ? 'white' : 'black'
                            },
                            grid: {
                                color: document.querySelector('html').classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: document.querySelector('html').classList.contains('dark') ? 'white' : 'black'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection