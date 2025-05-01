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

        <!-- Air Element Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Air & Water</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">
                        <span class="text-blue-600 dark:text-blue-400">{{ $airCount }}</span> / 
                        <span class="text-cyan-600 dark:text-cyan-400">{{ $waterCount }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Fire Element Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 mr-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Fire & Earth</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">
                        <span class="text-red-600 dark:text-red-400">{{ $fireCount }}</span> / 
                        <span class="text-green-600 dark:text-green-400">{{ $earthCount }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Element Distribution Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Element Distribution</h2>
            <div class="h-64">
                <canvas id="elementChart"></canvas>
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
                    <label for="element" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Element</label>
                    <select name="element" id="element" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">All Elements</option>
                        <option value="air" {{ request('element') == 'air' ? 'selected' : '' }}>Air</option>
                        <option value="earth" {{ request('element') == 'earth' ? 'selected' : '' }}>Earth</option>
                        <option value="fire" {{ request('element') == 'fire' ? 'selected' : '' }}>Fire</option>
                        <option value="water" {{ request('element') == 'water' ? 'selected' : '' }}>Water</option>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Element</th>
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
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($result->element === 'air' || $result->user->power == 'air')
                                    bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($result->element === 'fire' || $result->user->power == 'fire')
                                    bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @elseif($result->element === 'water' || $result->user->power == 'water')
                                    bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200
                                @elseif($result->element === 'earth' || $result->user->power == 'earth')
                                    bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @endif">
                                {{ ucfirst($result->element ? $result->element : $result->user->power) }}
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
            // Element Distribution Chart
            const elementCtx = document.getElementById('elementChart').getContext('2d');
            new Chart(elementCtx, {
                type: 'pie',
                data: {
                    labels: ['Air', 'Earth', 'Fire', 'Water'],
                    datasets: [{
                        data: [{{ $airCount }}, {{ $earthCount }}, {{ $fireCount }}, {{ $waterCount }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)', // Air - Blue
                            'rgba(16, 185, 129, 0.8)', // Earth - Green
                            'rgba(239, 68, 68, 0.8)',  // Fire - Red
                            'rgba(6, 182, 212, 0.8)'   // Water - Cyan
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(6, 182, 212, 1)'
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

