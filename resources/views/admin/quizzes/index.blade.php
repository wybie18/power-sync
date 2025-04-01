@extends('layouts.admin-dashboard-layout')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Quizzes</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage your quizzes</p>
        </div>
        <a href="{{ route('admin.quizzes.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Create Quiz
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b dark:border-gray-700">
            <form action="{{ route('admin.quizzes.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search quizzes..."
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Search
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Title</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Description</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Questions</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Created</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $quiz->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ Str::limit($quiz->description, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $quiz->questions_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $quiz->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.quizzes.show', $quiz) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">View</a>
                                    <a href="{{ route('admin.quizzes.edit', $quiz) }}"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                    <a href="{{ route('admin.quizzes.questions.index', $quiz) }}"
                                        class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">Questions</a>
                                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                            onclick="return confirm('Are you sure you want to delete this quiz?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $quizzes->links() }}
        </div>
    </div>
@endsection
