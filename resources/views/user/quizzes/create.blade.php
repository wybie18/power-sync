@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Taking: {{ $quiz->title }}</h1>
        <p class="text-gray-600 dark:text-gray-400">Answer all questions to discover your elemental power</p>
    </div>

    <form action="{{ route('user.quizzes.submit', $quiz) }}" method="POST">
        @csrf

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
            <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Quiz Progress</h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span id="current-question">1</span> of {{ $quiz->questions->count() }}
                </div>
            </div>
            <div class="p-4">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                    <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full"
                        style="width: {{ (1 / $quiz->questions->count()) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @foreach ($quiz->questions as $index => $question)
                <div id="question-{{ $index + 1 }}"
                    class="question-container bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden {{ $index > 0 ? 'hidden' : '' }}">
                    <div class="p-6 border-b dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Question {{ $index + 1 }}</h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <p class="text-gray-800 dark:text-white text-lg">{{ $question->question }}</p>
                        </div>

                        <div class="space-y-3">
                            @foreach ($question->answers->shuffle() as $answer)
                                <div class="flex items-center">
                                    <input type="radio" id="q{{ $question->id }}_a{{ $answer->id }}"
                                        name="answers[{{ $question->id }}]" value="{{ $answer->id }}"
                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                        required>
                                    <label for="q{{ $question->id }}_a{{ $answer->id }}"
                                        class="ml-3 block text-gray-700 dark:text-gray-300">
                                        {{ $answer->answer }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-between">
                            @if ($index > 0)
                                <button type="button"
                                    class="prev-question px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Previous
                                </button>
                            @else
                                <div></div>
                            @endif

                            @if ($index < $quiz->questions->count() - 1)
                                <button type="button"
                                    class="next-question px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Next
                                </button>
                            @else
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Submit Quiz
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionContainers = document.querySelectorAll('.question-container');
            const nextButtons = document.querySelectorAll('.next-question');
            const prevButtons = document.querySelectorAll('.prev-question');
            const progressBar = document.getElementById('progress-bar');
            const currentQuestionDisplay = document.getElementById('current-question');
            const totalQuestions = {{ $quiz->questions->count() }};

            let currentQuestion = 1;

            // Update progress display
            function updateProgress() {
                currentQuestionDisplay.textContent = currentQuestion;
                progressBar.style.width = `${(currentQuestion / totalQuestions) * 100}%`;
            }

            // Show a specific question
            function showQuestion(questionNumber) {
                questionContainers.forEach((container, index) => {
                    if (index + 1 === questionNumber) {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                });

                currentQuestion = questionNumber;
                updateProgress();
            }

            // Next button event listeners
            nextButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    // Check if current question has been answered
                    const currentQuestionId = questionContainers[index].id.split('-')[1];
                    const radioButtons = questionContainers[index].querySelectorAll(
                        'input[type="radio"]');
                    const isAnswered = Array.from(radioButtons).some(radio => radio.checked);

                    if (!isAnswered) {
                        alert('Please answer the current question before proceeding.');
                        return;
                    }

                    showQuestion(index + 2);
                });
            });

            // Previous button event listeners
            prevButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    showQuestion(index + 1);
                });
            });
        });
    </script>
@endsection
