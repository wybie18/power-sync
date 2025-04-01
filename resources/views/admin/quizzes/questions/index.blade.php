@extends('layouts.admin-dashboard-layout')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Questions for "{{ $quiz->title }}"</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage questions and answers</p>
        </div>
        <div class="space-x-2">
            <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'generate-questions')"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Generate
            </button>
            <a href="{{ route('admin.quizzes.questions.create', $quiz) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Add Question
            </a>
        </div>
    </div>

    <!-- Generate Questions Modal using the component -->
    <x-modal name="generate-questions" focusable maxWidth="md">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Generate Questions</h3>
                <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.quizzes.questions.generate', $quiz) }}" method="GET">
                <div class="space-y-4">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-white">Number of Questions</label>
                        <select id="amount" name="amount" class="mt-1 block w-full pl-3 pr-10 py-2 text-base dark:text-gray-300 border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            @foreach([5, 10, 15, 20] as $value)
                                <option value="{{ $value }}" {{ $value == 10 ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-white">Category</label>
                        <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 dark:text-gray-300 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="9">General Knowledge</option>
                            <option value="10">Entertainment: Books</option>
                            <option value="11">Entertainment: Film</option>
                            <option value="12">Entertainment: Music</option>
                            <option value="13">Entertainment: Musicals & Theatres</option>
                            <option value="14">Entertainment: Television</option>
                            <option value="15">Entertainment: Video Games</option>
                            <option value="16">Entertainment: Board Games</option>
                            <option value="17">Science & Nature</option>
                            <option value="18">Science: Computers</option>
                            <option value="19">Science: Mathematics</option>
                            <option value="20">Mythology</option>
                            <option value="21">Sports</option>
                            <option value="22">Geography</option>
                            <option value="23">History</option>
                            <option value="24">Politics</option>
                            <option value="25">Art</option>
                            <option value="26">Celebrities</option>
                            <option value="27">Animals</option>
                            <option value="28">Vehicles</option>
                            <option value="29">Entertainment: Comics</option>
                            <option value="30">Science: Gadgets</option>
                            <option value="31" selected>Entertainment: Japanese Anime & Manga</option>
                            <option value="32">Entertainment: Cartoon & Animations</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Generate
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
        <div class="p-6 border-b dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Quiz Details</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $quiz->description }}</p>
        </div>
    </div>

    @if ($questions->count() > 0)
        <div class="space-y-6">
            @foreach ($questions as $index => $question)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Question {{ $index + 1 }}:
                            {{ $question->question }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.questions.edit', $question) }}"
                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                    onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                            </form>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-4">Answers:</h4>
                        <div class="space-y-4">
                            @foreach ($question->answers as $answer)
                                <div class="flex items-center justify-between p-4 border rounded-lg dark:border-gray-700">
                                    <div class="flex items-center">
                                        <span class="text-gray-800 dark:text-gray-200">{{ $answer->answer }}</span>
                                        <span
                                            class="ml-4 px-2 py-1 text-xs font-semibold rounded-full {{ $answer->score > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            Score: {{ $answer->score }}
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.answers.edit', $answer) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                        <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                                onclick="return confirm('Are you sure you want to delete this answer?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.questions.answers.create', $question) }}"
                                class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Add Answer</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
            <p class="text-gray-600 dark:text-gray-400">No questions added yet. Click "Add Question" to get started.</p>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.quizzes.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">&larr; Back
            to Quizzes</a>
    </div>
@endsection