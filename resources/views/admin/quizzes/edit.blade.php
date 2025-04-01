@extends('layouts.admin-dashboard-layout')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Quiz</h1>
    <p class="text-gray-600 dark:text-gray-400">Update quiz information</p>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="p-6 space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $quiz->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
            <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Update Quiz
            </button>
        </div>
    </form>
</div>

<div class="mt-6">
    <a href="{{ route('admin.quizzes.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">&larr; Back to Quizzes</a>
</div>
@endsection