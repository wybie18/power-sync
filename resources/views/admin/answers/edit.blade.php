@extends('layouts.admin-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Answer</h1>
        <p class="text-gray-600 dark:text-gray-400">Update answer for the question: "{{ $answer->question->question }}"</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.answers.update', $answer) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer
                        Text</label>
                    <input type="text" name="answer" id="answer" value="{{ old('answer', $answer->answer) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('answer')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Score</label>
                    <div class="mt-1 flex items-center">
                        <input type="number" name="score" id="score" value="{{ old('score', $answer->score) }}"
                            class="block w-32 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                        <div class="ml-4 text-sm text-gray-500 dark:text-gray-400">
                            <p>Positive scores (e.g., 1, 2, 3) indicate hero alignment</p>
                            <p>Negative scores (e.g., -1, -2, -3) indicate villain alignment</p>
                        </div>
                    </div>
                    @error('score')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.questions.edit', $answer->question_id) }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Update Answer
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('admin.questions.edit', $answer->question_id) }}"
            class="text-indigo-600 dark:text-indigo-400 hover:underline">&larr; Back to Question</a>
        <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 hover:underline"
                onclick="return confirm('Are you sure you want to delete this answer?')">
                Delete Answer
            </button>
        </form>
    </div>
@endsection
