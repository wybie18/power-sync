@extends('layouts.admin-dashboard-layout')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Edit Question</h1>
    <p class="text-gray-600 dark:text-gray-400">Update question information</p>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <form action="{{ route('admin.questions.update', $question) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="p-6 space-y-6">
            <div>
                <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question</label>
                <input type="text" name="question" id="question" value="{{ old('question', $question->question) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('question')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <h3 class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Answers</h3>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    @if($question->answers->count() > 0)
                        <div class="space-y-4">
                            @foreach($question->answers as $index => $answer)
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $answer->answer }}</span>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $answer->score > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        Score: {{ $answer->score }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                            <p>To edit answers, please use the answer management interface.</p>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No answers available for this question.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
            <a href="{{ route('admin.quizzes.questions.index', $question->quiz_id) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Update Question
            </button>
        </div>
    </form>
</div>

<div class="mt-6">
    <a href="{{ route('admin.quizzes.questions.index', $question->quiz_id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">&larr; Back to Questions</a>
</div>
@endsection