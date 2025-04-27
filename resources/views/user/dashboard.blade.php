@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 dark:text-gray-400">Your personal dashboard</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">My Profile</h2>
            </div>
            <div class="p-6">
                <div class="flex flex-col items-center">
                    <div
                        class="w-20 h-20 rounded-full 
                        @if (Auth::user()->power === 'air') bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300
                        @elseif(Auth::user()->power === 'fire')
                            bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300
                        @elseif(Auth::user()->power === 'water')
                            bg-cyan-100 dark:bg-cyan-900 text-cyan-600 dark:text-cyan-300
                        @elseif(Auth::user()->power === 'earth')
                            bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300
                        @else
                            bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-300 @endif
                        flex items-center justify-center text-2xl font-bold mb-4">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>

                    @if (isset($userStats))
                        <div class="mt-4 w-full">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500 dark:text-gray-400">Quizzes Taken</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $userStats->quizzes_taken }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500 dark:text-gray-400">Elemental Power</span>
                                <span
                                    class="font-medium 
                                    @if (Auth::user()->power === 'air') text-blue-600 dark:text-blue-400
                                    @elseif(Auth::user()->power === 'fire')
                                        text-red-600 dark:text-red-400
                                    @elseif(Auth::user()->power === 'water')
                                        text-cyan-600 dark:text-cyan-400
                                    @elseif(Auth::user()->power === 'earth')
                                        text-green-600 dark:text-green-400
                                    @else
                                        text-gray-600 dark:text-gray-400 @endif">
                                    {{ Auth::user()->power ? ucfirst(Auth::user()->power) : 'Undiscovered' }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Experience</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->exp ?? 0 }}
                                    XP</span>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 text-center text-gray-500 dark:text-gray-400">
                            <p>Take your first quiz to see your stats!</p>
                        </div>
                    @endif

                    <a href="{{ route('user.profile.edit') }}"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Results Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Results</h2>
            </div>
            <div class="p-6">
                @if (isset($recentResults) && count($recentResults) > 0)
                    <div class="space-y-4">
                        @foreach ($recentResults as $result)
                            <div class="border-b dark:border-gray-700 pb-4 last:border-b-0 last:pb-0">
                                <div class="flex justify-between mt-1">
                                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $result->quiz->title }}</h3>
                                    <span
                                        class="text-sm text-gray-500 dark:text-gray-400">{{ $result->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                            style="width: {{ ($result->total_score / $result->max_possible_score) * 100 }}%">
                                        </div>
                                    </div>
                                    <div class="flex justify-between mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        <span>Score: {{ $result->total_score }}</span>
                                        <span>Max: {{ $result->max_possible_score }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('user.results.index') }}"
                            class="text-blue-600 dark:text-blue-400 hover:underline">View All Results</a>
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't taken any quizzes yet.</p>
                        <a href="{{ route('user.quizzes.index') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Take Your First Quiz
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <a href="{{ route('user.quizzes.random') }}"
                        class="block w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-center">
                        Take Random Quiz
                    </a>
                    <a href="{{ route('user.quizzes.index') }}"
                        class="block w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-center">
                        Browse All Quizzes
                    </a>
                    <a href="{{ route('user.typing.test.index') }}"
                        class="block w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-center">
                        Take Typing Test
                    </a>
                    <a href="{{ route('user.leaderboard') }}"
                        class="block w-full px-4 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                        View Leaderboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Elemental Power & Experience -->
    @if (isset($userStats) && $userStats->quizzes_taken > 0)
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Your Elemental Power</h2>
            </div>
            <div class="p-6">
                @if (Auth::user()->power)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-12 h-12 rounded-full flex items-center justify-center mr-4
                                    @if (Auth::user()->power === 'air') bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300
                                    @elseif(Auth::user()->power === 'fire')
                                        bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300
                                    @elseif(Auth::user()->power === 'water')
                                        bg-cyan-100 dark:bg-cyan-900 text-cyan-600 dark:text-cyan-300
                                    @elseif(Auth::user()->power === 'earth')
                                        bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 @endif">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        @if (Auth::user()->power === 'air')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                        @elseif(Auth::user()->power === 'fire')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                                        @elseif(Auth::user()->power === 'water')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        @elseif(Auth::user()->power === 'earth')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-medium 
                                        @if (Auth::user()->power === 'air') text-blue-600 dark:text-blue-400
                                        @elseif(Auth::user()->power === 'fire')
                                            text-red-600 dark:text-red-400
                                        @elseif(Auth::user()->power === 'water')
                                            text-cyan-600 dark:text-cyan-400
                                        @elseif(Auth::user()->power === 'earth')
                                            text-green-600 dark:text-green-400 @endif">
                                        {{ ucfirst(Auth::user()->power) }} Bender
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if (Auth::user()->power === 'air')
                                            You harness the power of wind and freedom
                                        @elseif(Auth::user()->power === 'fire')
                                            You command the fierce energy of flames
                                        @elseif(Auth::user()->power === 'water')
                                            You flow with the adaptability of water
                                        @elseif(Auth::user()->power === 'earth')
                                            You stand strong with the stability of earth
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Element Affinity</h4>
                                <div class="grid grid-cols-4 gap-2">
                                    <div class="text-center">
                                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mb-1">
                                            <div class="h-2 bg-blue-500 rounded-full"
                                                style="width: {{ Auth::user()->power === 'air' ? '100%' : '25%' }}"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Air</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mb-1">
                                            <div class="h-2 bg-red-500 rounded-full"
                                                style="width: {{ Auth::user()->power === 'fire' ? '100%' : '25%' }}"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Fire</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mb-1">
                                            <div class="h-2 bg-cyan-500 rounded-full"
                                                style="width: {{ Auth::user()->power === 'water' ? '100%' : '25%' }}">
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Water</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mb-1">
                                            <div class="h-2 bg-green-500 rounded-full"
                                                style="width: {{ Auth::user()->power === 'earth' ? '100%' : '25%' }}">
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Earth</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Experience Level</h4>
                            @php
                                // Calculate level based on experience points
                                $exp = Auth::user()->exp ?? 0;
                                $level = floor(sqrt($exp / 100)) + 1;
                                $nextLevel = $level + 1;
                                $expForCurrentLevel = ($level - 1) * ($level - 1) * 100;
                                $expForNextLevel = $level * $level * 100;
                                $expProgress = ($exp - $expForCurrentLevel) / ($expForNextLevel - $expForCurrentLevel) * 100;
                            @endphp

                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span
                                        class="text-lg font-bold 
                                        @if (Auth::user()->power === 'air') text-blue-600 dark:text-blue-400
                                        @elseif(Auth::user()->power === 'fire')
                                            text-red-600 dark:text-red-400
                                        @elseif(Auth::user()->power === 'water')
                                            text-cyan-600 dark:text-cyan-400
                                        @elseif(Auth::user()->power === 'earth')
                                            text-green-600 dark:text-green-400
                                        @else
                                            text-gray-600 dark:text-gray-400 @endif">
                                        Level {{ $level }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $exp }} XP</span>
                                </div>

                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 mb-1">
                                    <div class="
                                        @if (Auth::user()->power === 'air') bg-blue-600
                                        @elseif(Auth::user()->power === 'fire')
                                            bg-red-600
                                        @elseif(Auth::user()->power === 'water')
                                            bg-cyan-600
                                        @elseif(Auth::user()->power === 'earth')
                                            bg-green-600
                                        @else
                                            bg-blue-600 @endif
                                        h-2.5 rounded-full"
                                        style="width: {{ $expProgress }}%">
                                    </div>
                                </div>

                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ $expForCurrentLevel }} XP</span>
                                    <span>{{ $expForNextLevel }} XP</span>
                                </div>

                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                                    <p>{{ $expForNextLevel - $exp }} XP needed to reach Level {{ $nextLevel }}</p>
                                    <p class="mt-2">
                                        @if ($level < 5)
                                            Novice {{ ucfirst(Auth::user()->power) }} Bender
                                        @elseif($level < 10)
                                            Apprentice {{ ucfirst(Auth::user()->power) }} Bender
                                        @elseif($level < 15)
                                            Adept {{ ucfirst(Auth::user()->power) }} Bender
                                        @elseif($level < 20)
                                            Master {{ ucfirst(Auth::user()->power) }} Bender
                                        @else
                                            Legendary {{ ucfirst(Auth::user()->power) }} Bender
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Your elemental power has not yet been discovered.
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Take more quizzes to reveal your true element!
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
