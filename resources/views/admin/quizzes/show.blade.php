@extends('layouts.admin-dashboard-layout')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Quiz Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Edit Quiz
            </a>
            <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to delete this quiz?')">
                    Delete Quiz
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Quiz Information</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quiz->title }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quiz->description }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Questions</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quiz->questions->count() }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quiz->created_at->format('F d, Y') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quiz->updated_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mt-6">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Quiz Statistics</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Attempts</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $quiz->results->count() ?? 0 }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Hero Alignments</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $quiz->results->where('alignment', 'hero')->count() ?? 0 }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Villain Alignments</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $quiz->results->where('alignment', 'villain')->count() ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Questions</h2>
                <a href="{{ route('admin.quizzes.questions.create', $quiz) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Add Question
                </a>
            </div>
            <div class="p-6">
                @if($quiz->questions->count() > 0)
                    <div class="space-y-6">
                        @foreach($quiz->questions as $index => $question)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-md font-medium text-gray-900 dark:text-white">
                                        Question {{ $index + 1 }}: {{ $question->question }}
                                    </h3>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.questions.edit', $question) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this question?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                @if($question->answers->count() > 0)
                                    <div class="mt-4 pl-4 border-l-2 border-gray-200 dark:border-gray-600">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Answers:</h4>
                                        <ul class="space-y-2">
                                            @foreach($question->answers as $answer)
                                                <li class="flex justify-between items-center">
                                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $answer->answer }}</span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $answer->score > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                        Score: {{ $answer->score }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No answers available for this question.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400">No questions have been added to this quiz yet.</p>
                        <a href="{{ route('admin.quizzes.questions.create', $quiz) }}" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Your First Question
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.quizzes.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">&larr; Back to Quizzes</a>
</div>
@endsection