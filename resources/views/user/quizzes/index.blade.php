@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Available Quizzes</h1>
                <p class="text-gray-600 dark:text-gray-400">Choose a quiz to take or try a random one</p>
            </div>
            <a href="{{ route('user.quizzes.random') }}"
                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Random Quiz
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
        <div class="p-4">
            <form action="{{ route('user.quizzes.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="search"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Search quizzes..."
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Search
                    </button>
                    @if (request()->has('search'))
                        <a href="{{ route('user.quizzes.index') }}"
                            class="ml-2 px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Quizzes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($quizzes as $quiz)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $quiz->title }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $quiz->description }}</p>
                    <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span>{{ $quiz->questions_count }} questions</span>
                        <span>{{ $quiz->results_count }} attempts</span>
                    </div>
                    <a href="{{ route('user.quizzes.show', $quiz) }}"
                        class="block w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center">
                        Take Quiz
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400">No quizzes found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $quizzes->withQueryString()->links() }}
    </div>
@endsection
