@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Typing Test</h1>
                <p class="text-gray-600 dark:text-gray-400">Improve your typing speed and accuracy</p>
                {{$level}}
            </div>
            <button id="restart-test"
                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Restart Test
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
                    <p id="time" class="text-xl font-semibold text-gray-800 dark:text-white">0s</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">WPM</p>
                    <p id="wpm" class="text-xl font-semibold text-gray-800 dark:text-white">0</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Accuracy</p>
                    <p id="accuracy" class="text-xl font-semibold text-gray-800 dark:text-white">0%</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Errors</p>
                    <p id="errors" class="text-xl font-semibold text-gray-800 dark:text-white">0</p>
                </div>
            </div>

            <div class="mb-6">
                <div id="text-display" class="text-lg leading-relaxed bg-gray-50 dark:bg-gray-900 p-4 rounded-lg mb-4 min-h-[150px] focus:outline-2 focus:outline-indigo-500 cursor-text" tabindex="0">
                    {{ $paragraph }}
                </div>
                <div id="typing-cursor-position" class="text-gray-600 dark:text-gray-400 text-sm">
                    Click on the text above and start typing
                </div>
            </div>

            <form id="result-form" action="{{ route('user.typing.test.store') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="wpm" id="form-wpm" value="0">
                <input type="hidden" name="accuracy" id="form-accuracy" value="0">
                <input type="hidden" name="errors_count" id="form-errors" value="0">
                <input type="hidden" name="time_taken_seconds" id="form-time" value="0">
                <input type="hidden" name="typed_text" id="form-typed-text" value="">
                
                <button type="submit"
                    class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center">
                    Submit Results
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">How It Works</h2>
            <ul class="list-disc pl-5 space-y-2 text-gray-600 dark:text-gray-400">
                <li>Click on the text area above and start typing</li>
                <li>Type the text exactly as shown - correct characters will turn green, errors will turn red</li>
                <li>Your typing speed (WPM), accuracy, and errors will be calculated automatically</li>
                <li>When you complete the test, you'll earn experience points based on your performance</li>
                <li>Higher WPM and accuracy will earn you more experience points</li>
                <li>Press the "Restart Test" button to try again with a new paragraph</li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textDisplay = document.getElementById('text-display');
            const timeElement = document.getElementById('time');
            const wpmElement = document.getElementById('wpm');
            const accuracyElement = document.getElementById('accuracy');
            const errorsElement = document.getElementById('errors');
            const restartButton = document.getElementById('restart-test');
            const resultForm = document.getElementById('result-form');
            const typingCursorPosition = document.getElementById('typing-cursor-position');
            
            const formWpm = document.getElementById('form-wpm');
            const formAccuracy = document.getElementById('form-accuracy');
            const formErrors = document.getElementById('form-errors');
            const formTime = document.getElementById('form-time');
            const formTypedText = document.getElementById('form-typed-text');
            
            let startTime;
            let timer;
            let originalText = textDisplay.innerText.trim();
            let typedText = '';
            let currentPosition = 0;
            let totalErrors = 0;
            let isTestActive = false;
            let isTestComplete = false;
            
            function formatTextDisplay() {
                let formattedText = '';
                for (let i = 0; i < originalText.length; i++) {
                    formattedText += `<span id="char-${i}" class="char">${originalText[i]}</span>`;
                }
                textDisplay.innerHTML = formattedText;
            }
            
            function startTimer() {
                startTime = new Date();
                timer = setInterval(updateTimer, 1000);
                isTestActive = true;
            }
            
            function updateTimer() {
                if (!isTestActive) return;
                
                const currentTime = new Date();
                const elapsedTime = Math.floor((currentTime - startTime) / 1000);
                timeElement.textContent = `${elapsedTime}s`;
                formTime.value = elapsedTime;
                
                updateWPM(elapsedTime);
            }
            
            function updateWPM(elapsedTime) {
                if (elapsedTime === 0) return;
                
                const wordCount = typedText.length / 5;
                const minutes = elapsedTime / 60;
                const wpm = Math.round(wordCount / minutes);
                
                wpmElement.textContent = wpm;
                formWpm.value = wpm;
            }
            
            function handleKeyPress(e) {
                if (isTestComplete) return;
                
                if (!isTestActive) {
                    startTimer();
                }
                
                if (e.key.length !== 1) {
                    if (e.key === 'Backspace' && currentPosition > 0) {
                        currentPosition--;
                        typedText = typedText.substring(0, currentPosition);
                        updateDisplay();
                    }
                    return;
                }
                e.preventDefault();
                
                if (currentPosition < originalText.length) {
                    typedText = typedText.substring(0, currentPosition) + e.key;
                    currentPosition++;
                    updateDisplay();
                    
                    if (currentPosition >= originalText.length) {
                        completeTest();
                    }
                }
            }
            
            function updateDisplay() {
                let correctChars = 0;
                totalErrors = 0;
                
                document.querySelectorAll('.char').forEach((charSpan, index) => {
                    charSpan.className = 'char';
                    if (index === currentPosition) {
                        charSpan.className += ' bg-indigo-200 dark:bg-indigo-700';
                    }
                });
                
                for (let i = 0; i < typedText.length; i++) {
                    const charSpan = document.getElementById(`char-${i}`);
                    if (!charSpan) continue;
                    
                    if (typedText[i] === originalText[i]) {
                        charSpan.className = 'char text-green-500';
                        correctChars++;
                    } else {
                        charSpan.className = 'char text-red-500';
                        totalErrors++;
                    }
                }
                
                if (currentPosition < originalText.length) {
                    typingCursorPosition.textContent = `Current position: ${currentPosition}/${originalText.length}`;
                } else {
                    typingCursorPosition.textContent = `Completed!`;
                }
                
                if (currentPosition < originalText.length) {
                    const currentChar = document.getElementById(`char-${currentPosition}`);
                    if (currentChar) {
                        currentChar.className += ' bg-indigo-200 dark:bg-indigo-700';
                    }
                }
                
                errorsElement.textContent = totalErrors;
                formErrors.value = totalErrors;
                
                const accuracy = Math.max(0, Math.round((correctChars / Math.max(1, typedText.length)) * 100));
                accuracyElement.textContent = `${accuracy}%`;
                formAccuracy.value = accuracy;
                
                formTypedText.value = typedText;
            }
            
            function completeTest() {
                isTestActive = false;
                isTestComplete = true;
                clearInterval(timer);
                resultForm.classList.remove('hidden');
            }
            
            function restartTest() {
                window.location.reload();
            }
            
            formatTextDisplay();
            textDisplay.addEventListener('click', function() {
                textDisplay.focus();
            });
            textDisplay.addEventListener('keydown', handleKeyPress);
            restartButton.addEventListener('click', restartTest);
        });
    </script>
@endsection