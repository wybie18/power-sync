@extends('layouts.admin-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Add Question to "{{ $quiz->title }}"</h1>
        <p class="text-gray-600 dark:text-gray-400">Create a new question with answers</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question</label>
                    <input type="text" name="question" id="question" value="{{ old('question') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    @error('question')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Answers</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Add answers with scores. Positive scores tend
                        toward "hero" alignment, negative scores toward "villain" alignment.</p>

                    <div id="answers-container" class="space-y-4">
                        <div class="answer-group border dark:border-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-3">
                                    <label for="answers[0][answer]"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer
                                        Text</label>
                                    <input type="text" name="answers[0][answer]"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="answers[0][score]"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Score</label>
                                    <input type="number" name="answers[0][score]"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-answer"
                        class="mt-4 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Add Another Answer
                    </button>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                <a href="{{ route('admin.quizzes.questions.index', $quiz) }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save Question
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('answers-container');
            const addButton = document.getElementById('add-answer');
            let answerCount = 1;

            addButton.addEventListener('click', function() {
                const answerGroup = document.createElement('div');
                answerGroup.className = 'answer-group border dark:border-gray-700 rounded-lg p-4';

                answerGroup.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-3">
                            <label for="answers[${answerCount}][answer]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer Text</label>
                            <input type="text" name="answers[${answerCount}][answer]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="answers[${answerCount}][score]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Score</label>
                            <input type="number" name="answers[${answerCount}][score]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                    </div>
                    <button type="button" class="remove-answer mt-2 text-sm text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Remove</button>
                `;

                container.appendChild(answerGroup);
                answerCount++;

                const removeButton = answerGroup.querySelector('.remove-answer');
                removeButton.addEventListener('click', function() {
                    container.removeChild(answerGroup);
                });
            });
        });
    </script>
@endsection
