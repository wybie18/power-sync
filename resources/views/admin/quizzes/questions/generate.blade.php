@extends('layouts.admin-dashboard-layout')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Generated Questions for "{{ $quiz->title }}"</h1>
    <p class="text-gray-600 dark:text-gray-400">Review and customize the generated questions before adding them to your quiz</p>
</div>

<!-- Question Navigation -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
    <div class="p-4 border-b dark:border-gray-700">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Question Navigator</h2>
    </div>
    <div class="p-4 overflow-x-auto">
        <div class="flex space-x-2">
            @foreach($questions as $index => $question)
                <a href="#question-{{ $index }}" class="flex-shrink-0 px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Q{{ $index + 1 }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<form action="{{ route('admin.quizzes.questions.storeGenerated', $quiz) }}" method="POST">
    @csrf
    <div class="space-y-6">
        @foreach($questions as $index => $question)
            <div id="question-{{ $index }}" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white">Question {{ $index + 1 }}</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <div>
                        <label for="questions[{{ $index }}][question]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question</label>
                        <input type="text" name="questions[{{ $index }}][question]" id="questions[{{ $index }}][question]" 
                            value="{{ htmlspecialchars($question['question']) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error("questions.{$index}.question")
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t dark:border-gray-700 pt-6">
                        <h4 class="text-md font-medium text-gray-800 dark:text-white mb-4">Answers</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Set scores and elements for each answer. Positive scores increase the user's elemental power, while negative scores decrease it. 
                        </p>

                        <div class="space-y-4">
                            <!-- Correct Answer -->
                            <div class="border dark:border-gray-700 rounded-lg p-4 bg-green-50 dark:bg-green-900/20">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="md:col-span-3">
                                        <label for="questions[{{ $index }}][answers][0][answer]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Correct Answer
                                        </label>
                                        <input type="text" name="questions[{{ $index }}][answers][0][answer]" 
                                            value="{{ htmlspecialchars($question['correct_answer']) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                    <div>
                                        <label for="questions[{{ $index }}][answers][0][score]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Score</label>
                                        <input type="number" name="questions[{{ $index }}][answers][0][score]" value="2" 
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Incorrect Answers -->
                            @foreach($question['incorrect_answers'] as $answerIndex => $incorrectAnswer)
                                <div class="border dark:border-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-3">
                                            <label for="questions[{{ $index }}][answers][{{ $answerIndex + 1 }}][answer]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Incorrect Answer
                                            </label>
                                            <input type="text" name="questions[{{ $index }}][answers][{{ $answerIndex + 1 }}][answer]" 
                                                value="{{ htmlspecialchars($incorrectAnswer) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>
                                        <div>
                                            <label for="questions[{{ $index }}][answers][{{ $answerIndex + 1 }}][score]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Score</label>
                                            <input type="number" name="questions[{{ $index }}][answers][{{ $answerIndex + 1 }}][score]" value="-1" 
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-between items-center">
            <div class="flex items-center">
                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700">
                <label for="select-all" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Select All Questions</label>
            </div>
            <div>
                <a href="{{ route('admin.quizzes.show', $quiz) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Selected Questions
                </button>
            </div>
        </div>
    </div>
</form>

<div class="mt-6">
    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">&larr; Back to Quiz</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const questionContainers = document.querySelectorAll('[id^="question-"]');
        
        // Add checkboxes to each question
        questionContainers.forEach((container, index) => {
            const header = container.querySelector('.p-4.border-b');
            
            // Create checkbox container
            const checkboxContainer = document.createElement('div');
            checkboxContainer.className = 'flex items-center justify-between';
            
            // Move existing heading into the container
            const heading = header.querySelector('h3');
            checkboxContainer.appendChild(heading);
            
            // Create checkbox
            const checkboxWrapper = document.createElement('div');
            checkboxWrapper.innerHTML = `
                <input type="checkbox" id="select-question-${index}" name="questions[${index}][selected]" value="1" checked
                    class="question-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700">
                <label for="select-question-${index}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Include</label>
            `;
            checkboxContainer.appendChild(checkboxWrapper);
            
            // Replace header content
            header.innerHTML = '';
            header.appendChild(checkboxContainer);
        });
        
        // Handle "Select All" functionality
        selectAllCheckbox.addEventListener('change', function() {
            const questionCheckboxes = document.querySelectorAll('.question-checkbox');
            questionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
        
        // Update "Select All" when individual checkboxes change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('question-checkbox')) {
                const allCheckboxes = document.querySelectorAll('.question-checkbox');
                const allChecked = Array.from(allCheckboxes).every(checkbox => checkbox.checked);
                selectAllCheckbox.checked = allChecked;
            }
        });
        
        // Decode HTML entities in question and answer fields
        document.querySelectorAll('input[type="text"]').forEach(input => {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = input.value;
            input.value = textarea.value;
        });
    });
</script>
@endsection