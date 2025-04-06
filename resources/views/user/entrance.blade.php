<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PowerSync') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Main Content -->
        <div>
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="flex items-center justify-between h-16 px-4">
                    <button @click="open = !open" class="md:hidden">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="flex items-center ml-auto">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center text-gray-700 dark:text-gray-300 focus:outline-none">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1">
                                <a href="{{ route('user.profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-12">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Entrance Examination:
                        {{ $quiz->title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">Complete this exam to determine your eligibility and
                        elemental affinity</p>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                <strong>Important:</strong> This is an entrance examination. Your results will determine
                                your elemental affinity and placement. Please answer all questions carefully.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
                    <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                        <div class="flex items-center">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-white">Exam Progress</h2>
                        </div>
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

                <form action="{{ route('user.quizzes.entrance.submit', $quiz) }}" method="POST" id="quiz-form">
                    @csrf

                    <div class="space-y-6">
                        @foreach ($quiz->questions as $index => $question)
                            <div id="question-{{ $index + 1 }}"
                                class="question-container bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden {{ $index > 0 ? 'hidden' : '' }}">
                                <div class="p-6 border-b dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Question
                                        {{ $index + 1 }}</h3>
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
                                                Submit Exam
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>

                <div class="fixed bottom-4 right-4 z-10">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Question Navigator</h4>
                            <button id="toggle-navigator"
                                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div id="navigator-content" class="hidden">
                            <div class="grid grid-cols-5 gap-2 max-h-40 overflow-y-auto">
                                @foreach ($quiz->questions as $index => $question)
                                    <button type="button" data-question="{{ $index + 1 }}"
                                        class="navigator-btn px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>




            </main>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questionContainers = document.querySelectorAll('.question-container');
        const nextButtons = document.querySelectorAll('.next-question');
        const prevButtons = document.querySelectorAll('.prev-question');
        const progressBar = document.getElementById('progress-bar');
        const currentQuestionDisplay = document.getElementById('current-question');
        const totalQuestions = {{ $quiz->questions->count() }};
        const navigatorButtons = document.querySelectorAll('.navigator-btn');
        const toggleNavigator = document.getElementById('toggle-navigator');
        const navigatorContent = document.getElementById('navigator-content');

        let currentQuestion = 1;
        let answeredQuestions = new Set();

        // Update progress display
        function updateProgress() {
            currentQuestionDisplay.textContent = currentQuestion;
            progressBar.style.width = `${(currentQuestion / totalQuestions) * 100}%`;

            // Update navigator buttons
            navigatorButtons.forEach(btn => {
                const qNum = parseInt(btn.dataset.question);
                btn.classList.remove('bg-blue-600', 'text-white', 'bg-green-600');

                if (qNum === currentQuestion) {
                    btn.classList.add('bg-blue-600', 'text-white');
                } else if (answeredQuestions.has(qNum)) {
                    btn.classList.add('bg-green-600', 'text-white');
                }
            });
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

        // Toggle question navigator
        toggleNavigator.addEventListener('click', function() {
            navigatorContent.classList.toggle('hidden');
        });

        // Navigator button event listeners
        navigatorButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const questionNumber = parseInt(this.dataset.question);
                showQuestion(questionNumber);
            });
        });

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

                answeredQuestions.add(currentQuestion);
                showQuestion(index + 2);
            });
        });

        // Previous button event listeners
        prevButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                showQuestion(index + 1);
            });
        });

        // Check for answered questions on radio button change
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const questionContainer = this.closest('.question-container');
                const questionNumber = parseInt(questionContainer.id.split('-')[1]);
                answeredQuestions.add(questionNumber);
                updateProgress();
            });
        });

        // Start the timer
        startTimer();

        // Initial progress update
        updateProgress();
    });
</script>

</html>
